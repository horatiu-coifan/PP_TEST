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

    public function findByLogin(int $loginId){

        $query = $this -> createQueryBuilder('t');
        $query
            -> innerJoin('t.client', 'c')
            -> where('c.credentials = :loginId')
            -> setParameter('loginId', $loginId)
            -> select('t, c')
            -> addOrderBy('t.date', 'ASC');
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
