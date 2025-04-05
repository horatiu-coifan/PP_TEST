<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\Clients1Type;
use App\Repository\ClientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/clients/crud')]
final class ClientsCrudController extends AbstractController
{
    #[Route(name: 'app_clients_crud_index', methods: ['GET'])]
    public function index(RequestStack $requestStack, ClientsRepository $clientsRepository): Response
    {
        return $this->render('clients_crud/index.html.twig', array_merge([
            'clients' => $clientsRepository->findAllEx(),
        ], $requestStack -> getSession() -> get("menuOptions")));
    }

    #[Route('/new', name: 'app_clients_crud_new', methods: ['GET', 'POST'])]
    public function new(RequestStack $requestStack, Request $request, EntityManagerInterface $entityManager): Response
    {
        $client = new Clients();
        $form = $this->createForm(Clients1Type::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client -> setInsDate(new \DateTime());
            $client -> setInsUid($requestStack -> getSession() -> get("menuOptions")["userName"]);
            $client -> setModDate(new \DateTime());
            $client -> setModUid($requestStack -> getSession() -> get("menuOptions")["userName"]);
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('app_clients_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('clients_crud/new.html.twig', array_merge([
            'client' => $client,
            'form' => $form,
        ], $requestStack -> getSession() -> get("menuOptions")));
    }

    #[Route('/{id}', name: 'app_clients_crud_show', methods: ['GET'])]
    public function show(RequestStack $requestStack, Clients $client): Response
    {
        return $this->render('clients_crud/show.html.twig', array_merge([
            'client' => $client,
        ], $requestStack -> getSession() -> get("menuOptions")));
    }

    #[Route('/{id}/edit', name: 'app_clients_crud_edit', methods: ['GET', 'POST'])]
    public function edit(RequestStack $requestStack, Request $request, Clients $client, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Clients1Type::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client -> setModDate(new \DateTime());
            $client -> setModUid($requestStack -> getSession() -> get("menuOptions")["userName"]);
            $entityManager->flush();

            return $this->redirectToRoute('app_clients_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('clients_crud/edit.html.twig', array_merge([
            'client' => $client,
            'form' => $form,
        ], $requestStack -> getSession() -> get("menuOptions")));
    }

    #[Route('/{id}', name: 'app_clients_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Clients $client, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_clients_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
