<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findAllActive(): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.active = true')
            ->orderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findDistinctPlatforms(): array
    {
        $results = $this->createQueryBuilder('p')
            ->select('DISTINCT p.platform')
            ->where('p.platform IS NOT NULL')
            ->orderBy('p.platform', 'ASC')
            ->getQuery()
            ->getScalarResult();

        return array_column($results, 'platform');
    }
}