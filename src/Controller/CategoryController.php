<?php

namespace App\Controller;

use App\Service\ProductSearch;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categories', name: 'category_')]
class CategoryController extends AbstractController
{
    public function __construct(
        private ProductSearch $productSearch
    ) {}

    // Liste de toutes les catégories
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    // Détail d'une catégorie avec ses produits
    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show(int $id, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Catégorie introuvable.');
        }

        return $this->render('category/show.html.twig', [
            'category'  => $category,
            'platforms' => $this->productSearch->getAvailablePlatforms(),
        ]);
    }
}