<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * Recherche par mot-clé dans le nom ou la description
     */
    public function searchByKeyword(string $keyword): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.name LIKE :kw OR p.description LIKE :kw')
            ->setParameter('kw', '%' . $keyword . '%')
            ->orderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Filtre les produits selon plusieurs critères
     */
    public function findByFilters(array $filters): array
    {
        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.category', 'c');

        if (!empty($filters['category'])) {
            $qb->andWhere('c.id = :category')
               ->setParameter('category', $filters['category']);
        }

        if (!empty($filters['platform'])) {
            $qb->andWhere('p.platform = :platform')
               ->setParameter('platform', $filters['platform']);
        }

        if (!empty($filters['minPrice'])) {
            $qb->andWhere('p.price >= :minPrice')
               ->setParameter('minPrice', $filters['minPrice']);
        }

        if (!empty($filters['maxPrice'])) {
            $qb->andWhere('p.price <= :maxPrice')
               ->setParameter('maxPrice', $filters['maxPrice']);
        }

        if (!empty($filters['inStock'])) {
            $qb->andWhere('p.stock > 0');
        }

        if (!empty($filters['year'])) {
            $qb->andWhere('p.releaseYear = :year')
               ->setParameter('year', $filters['year']);
        }

        return $qb->orderBy('p.name', 'ASC')
                  ->getQuery()
                  ->getResult();
    }

    /**
     * Produits avec stock faible
     */
    public function findLowStock(int $threshold = 3, int $limit = 5): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.stock > 0')
            ->andWhere('p.stock <= :threshold')
            ->setParameter('threshold', $threshold)
            ->orderBy('p.stock', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * Plateformes distinctes
     */
    public function findDistinctPlatforms(): array
    {
        return $this->createQueryBuilder('p')
            ->select('DISTINCT p.platform')
            ->where('p.platform IS NOT NULL')
            ->orderBy('p.platform', 'ASC')
            ->getQuery()
            ->getSingleColumnResult();
    }

    /**
     * Années distinctes
     */
    public function findDistinctYears(): array
    {
        return $this->createQueryBuilder('p')
            ->select('DISTINCT p.releaseYear')
            ->where('p.releaseYear IS NOT NULL')
            ->orderBy('p.releaseYear', 'DESC')
            ->getQuery()
            ->getSingleColumnResult();
    }
}