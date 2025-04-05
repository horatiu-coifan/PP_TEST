<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReportsController extends AbstractController
{
    #[Route('/reports', name: 'reports')]
    public function index(RequestStack $requestStack): Response
    {
        return $this->render('reports/index.html.twig', array_merge([
            'controller_name' => 'ReportsController',
        ], $requestStack -> getSession() -> get("menuOptions")));
    }
}


// class ProductRepository extends ServiceEntityRepository
// {
//     public function findAllGreaterThanPrice(int $price): array
//     {
//         $conn = $this->getEntityManager()->getConnection();

//         $sql = '
//             SELECT * FROM product p
//             WHERE p.price > :price
//             ORDER BY p.price ASC
//             ';

//         $resultSet = $conn->executeQuery($sql, ['price' => $price]);

//         // returns an array of arrays (i.e. a raw data set)
//         return $resultSet->fetchAllAssociative();
//     }
// }
