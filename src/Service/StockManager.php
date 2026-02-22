<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class StockManager
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    /**
     * Vérifie si un produit est en stock
     */
    public function isAvailable(Product $product): bool
    {
        return $product->getStock() > 0;
    }

    /**
     * Vérifie si la quantité demandée est disponible
     */
    public function hasEnough(Product $product, int $quantity): bool
    {
        return $product->getStock() >= $quantity;
    }

    /**
     * Décrémente le stock d'un produit
     * Lève une exception si stock insuffisant
     */
    public function decrement(Product $product, int $quantity = 1): void
    {
        if (!$this->hasEnough($product, $quantity)) {
            throw new \LogicException(
                sprintf('Stock insuffisant pour "%s" (disponible: %d, demandé: %d)',
                    $product->getName(),
                    $product->getStock(),
                    $quantity
                )
            );
        }

        $product->setStock($product->getStock() - $quantity);
        $this->em->flush();
    }

    /**
     * Incrémente le stock (réapprovisionnement)
     */
    public function increment(Product $product, int $quantity = 1): void
    {
        $product->setStock($product->getStock() + $quantity);
        $this->em->flush();
    }

    /**
     * Retourne les produits avec un stock inférieur au seuil donné
     */
    public function getLowStockProducts(array $products, int $threshold = 3): array
    {
        return array_filter($products, fn(Product $p) => $p->getStock() <= $threshold);
    }
}