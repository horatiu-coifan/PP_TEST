<?php

namespace App\Repository;

use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Products>
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }

    public function save(Products $product, bool $flush = false) : void{
        $em = $this -> getEntityManager();
        $em -> persist($product);
        if($flush) $em -> flush();
    }

    public function delete(Products $product, bool $flush = false) : void{
        $em = $this -> getEntityManager();
        $em -> remove($product);
        if($flush) $em -> flush();
    }

    public function findAllArr() : array{
        $query = $this -> createQueryBuilder('p');
        $resp = $query -> getQuery();
        return $resp -> getArrayResult();
    }
}
