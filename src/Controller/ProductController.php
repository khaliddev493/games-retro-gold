<?php

namespace App\Controller;

use App\Service\PriceCalculator;
use App\Service\StockManager;
use App\Service\ProductSearch;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/produits', name: 'product_')]
class ProductController extends AbstractController
{
    public function __construct(
        private PriceCalculator $priceCalculator,
        private StockManager    $stockManager,
        private ProductSearch   $productSearch,
    ) {}

    #[Route('/', name: 'index')]
    public function index(Request $request, ProductRepository $productRepository): Response
    {
        $query = $request->query->get('q', '');

        if (!empty($query)) {
            $products = $this->productSearch->search($query);
        } else {
            $products = $productRepository->findAll();
        }

        return $this->render('product/index.html.twig', [
            'products'  => $products,
            'query'     => $query,
            'platforms' => $this->productSearch->getAvailablePlatforms(),
            'years'     => $this->productSearch->getAvailableYears(),
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show(int $id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Produit introuvable.');
        }

        return $this->render('product/show.html.twig', [
            'product'     => $product,
            'priceHT'     => $this->priceCalculator->getHT($product->getPrice()),
            'tva'         => $this->priceCalculator->getTVA($product->getPrice()),
            'isAvailable' => $this->stockManager->isAvailable($product),
        ]);
    }
}