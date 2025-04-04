<?php

namespace App\Controller;

use App\Entity\County;
use App\Form\CountyType;
use App\Repository\CountyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/county/crud')]
final class CountyCrudController extends AbstractController
{
    #[Route(name: 'app_county_crud_index', methods: ['GET'])]
    public function index(RequestStack $requestStack, CountyRepository $countyRepository): Response
    {
        return $this->render('county_crud/index.html.twig', array_merge([
            'counties' => $countyRepository->findAll(),
        ], $requestStack -> getSession() -> get('menuOptions')));
    }

    #[Route('/new', name: 'app_county_crud_new', methods: ['GET', 'POST'])]
    public function new(RequestStack $requestStack, Request $request, EntityManagerInterface $entityManager): Response
    {
        $county = new County();
        $form = $this->createForm(CountyType::class, $county);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($county);
            $entityManager->flush();

            return $this->redirectToRoute('app_county_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('county_crud/new.html.twig', array_merge([
            'county' => $county,
            'form' => $form,
        ], $requestStack -> getSession() -> get('menuOptions')));
    }

    #[Route('/{id}', name: 'app_county_crud_show', methods: ['GET'])]
    public function show(RequestStack $requestStack, County $county): Response
    {
        return $this->render('county_crud/show.html.twig', array_merge([
            'county' => $county,
        ],$requestStack -> getSession() -> get('menuOptions')));
    }

    #[Route('/{id}/edit', name: 'app_county_crud_edit', methods: ['GET', 'POST'])]
    public function edit(RequestStack $requestStack, Request $request, County $county, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CountyType::class, $county);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_county_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('county_crud/edit.html.twig', array_merge([
            'county' => $county,
            'form' => $form,
        ], $requestStack -> getSession() -> get('menuOptions')));
    }

    #[Route('/{id}', name: 'app_county_crud_delete', methods: ['POST'])]
    public function delete(Request $request, County $county, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$county->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($county);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_county_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
