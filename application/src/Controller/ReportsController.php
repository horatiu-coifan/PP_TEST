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
