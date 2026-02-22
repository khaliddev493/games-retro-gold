<?php

namespace App\Service;

use App\Repository\ProductRepository;

class ProductSearch
{
    public function __construct(
        private ProductRepository $productRepository
    ) {}

    /**
     * Recherche des produits par nom ou description
     */
    public function search(string $query): array
    {
        if (empty(trim($query))) {
            return [];
        }

        return $this->productRepository->searchByKeyword($query);
    }

    /**
     * Filtre les produits selon plusieurs critères
     *
     * @param array $filters [
     *   'category'  => int|null,      // id de la catégorie
     *   'platform'  => string|null,   // ex: 'NES', 'SNES'
     *   'minPrice'  => float|null,    // prix minimum
     *   'maxPrice'  => float|null,    // prix maximum
     *   'inStock'   => bool|null,     // uniquement en stock
     *   'year'      => int|null,      // année de sortie
     * ]
     */
    public function filter(array $filters = []): array
    {
        return $this->productRepository->findByFilters($filters);
    }

    /**
     * Retourne toutes les plateformes distinctes disponibles
     */
    public function getAvailablePlatforms(): array
    {
        return $this->productRepository->findDistinctPlatforms();
    }

    /**
     * Retourne toutes les années de sortie distinctes
     */
    public function getAvailableYears(): array
    {
        return $this->productRepository->findDistinctYears();
    }
}