<?php

namespace App\Controller;

use App\Service\ProductStats;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private ProductStats $productStats
    ) {}

    #[Route('/', name: 'home')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'latest'     => $this->productStats->getLatest(4),
        ]);
    }
}