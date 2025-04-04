<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/products/crud')]
final class ProductsCrudController extends AbstractController
{
    #[Route(name: 'app_products_crud_index', methods: ['GET'])]
    public function index(RequestStack $requestStack,ProductsRepository $productsRepository): Response
    {
        return $this->render('products_crud/index.html.twig',  array_merge([
            'products' => $productsRepository->findAll(),
        ], $requestStack -> getSession() -> get('menuOptions')));
    }

    #[Route('/new', name: 'app_products_crud_new', methods: ['GET', 'POST'])]
    public function new(RequestStack $requestStack, Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Products();
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_products_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('products_crud/new.html.twig', array_merge([
            'product' => $product,
            'form' => $form,
        ], $requestStack -> getSession() -> get('menuOptions')));
    }

    #[Route('/{id}', name: 'app_products_crud_show', methods: ['GET'])]
    public function show(RequestStack $requestStack, Products $product): Response
    {
        return $this->render('products_crud/show.html.twig', array_merge([
            'product' => $product,
        ], $requestStack -> getSession() -> get('menuOptions')));
    }

    #[Route('/{id}/edit', name: 'app_products_crud_edit', methods: ['GET', 'POST'])]
    public function edit(RequestStack $requestStack, Request $request, Products $product, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_products_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('products_crud/edit.html.twig', array_merge([
            'product' => $product,
            'form' => $form,
        ], $requestStack -> getSession() -> get('menuOptions')));
    }

    #[Route('/{id}', name: 'app_products_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Products $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_products_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
