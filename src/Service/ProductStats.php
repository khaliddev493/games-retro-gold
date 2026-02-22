<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;

class ProductStats
{
    public function __construct(
        private ProductRepository $productRepository
    ) {}

    /**
     * Retourne les N produits avec le stock le plus faible (> 0)
     */
    public function getLowStock(int $limit = 5, int $threshold = 3): array
    {
        return $this->productRepository->findLowStock($threshold, $limit);
    }

    /**
     * Retourne les produits en rupture de stock
     */
    public function getOutOfStock(): array
    {
        return $this->productRepository->findBy(['stock' => 0]);
    }

    /**
     * Retourne le prix moyen de tous les produits
     */
    public function getAveragePrice(): float
    {
        $products = $this->productRepository->findAll();

        if (empty($products)) {
            return 0.0;
        }

        $total = array_sum(array_map(
            fn(Product $p) => (float) $p->getPrice(),
            $products
        ));

        return round($total / count($products), 2);
    }

    /**
     * Retourne le stock total de tous les produits
     */
    public function getTotalStock(): int
    {
        $products = $this->productRepository->findAll();

        return array_sum(array_map(
            fn(Product $p) => $p->getStock(),
            $products
        ));
    }

    /**
     * Retourne la valeur totale du stock (prix * stock)
     */
    public function getTotalStockValue(): float
    {
        $products = $this->productRepository->findAll();

        return round(array_sum(array_map(
            fn(Product $p) => (float) $p->getPrice() * $p->getStock(),
            $products
        )), 2);
    }

    /**
     * Retourne les N derniers produits ajoutés
     */
    public function getLatest(int $limit = 4): array
    {
        return $this->productRepository->findBy([], ['id' => 'DESC'], $limit);
    }
}