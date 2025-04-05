<?php

namespace App\Repository;

use App\Entity\Clients;
use App\Entity\Transactions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use SessionIdInterface;

/**
 * @extends ServiceEntityRepository<Transactions>
 */
class TransactionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transactions::class);
    }

    public function findByLogin(?int $loginId): array{

        $query = $this -> createQueryBuilder('t');
        $query
            -> innerJoin('t.client', 'c');
        if($loginId){
            $query -> where('c.credentials = :loginId')
                -> setParameter('loginId', $loginId);
        }
        $query
            -> innerJoin('t.product','p')
            -> select('t, c, p')
            -> addOrderBy('c.name', 'ASC')
            -> addOrderBy('t.date', 'ASC');
        $resp = $query -> getQuery();
        return $resp -> getResult();
    }

    public function getReport($arrParams) : array{
        $query = $this -> createQueryBuilder('t');
        $query
            -> select('p.name, count(t.status) AS tsnr, t.status')
            -> join('t.product', 'p');
        if($arrParams["from_date"]){
            $query  -> where('t.date >= :from_date')
                    -> setParameter('from_date', $arrParams["from_date"]);
        }
        if($arrParams["to_date"]){
            $query  -> andWhere('t.date <= :to_date')
                    -> setParameter('to_date', $arrParams["to_date"]);
        }
        if($arrParams["type"]!==""){
            $query  -> andWhere('t.status = :type')
                    -> setParameter('type', $arrParams["type"]);
        }
        if($arrParams["product"]){
            $query  -> andWhere('t.product = :product')
                    -> setParameter('product', $arrParams["product"]);
        }
        $query
                -> groupBy('t.status, t.product');
                

        $resp = $query -> getQuery();

        return $resp -> getResult();
    }

    //    /**
    //     * @return Transactions[] Returns an array of Transactions objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Transactions
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
