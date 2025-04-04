<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Entity\Transactions;
use App\Form\Transactions1Type;
use App\Repository\TransactionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/transactions/crud')]
final class TransactionsCrudController extends AbstractController
{
    #[Route(name: 'app_transactions_crud_index', methods: ['GET'])]
    public function index(RequestStack $requestStack, TransactionsRepository $transactionsRepository): Response
    {
        $transactions = $requestStack -> getSession() -> get('userType') != 'admin' ? 
                        $transactionsRepository->findByLogin($requestStack -> getSession() -> get("loginId")) : 
                        $transactionsRepository->findAll();
        return $this->render('transactions_crud/index.html.twig', array_merge([
            'transactions' => $transactions
        ], $requestStack -> getSession() -> get("menuOptions")));
    }

    #[Route('/new', name: 'app_transactions_crud_new', methods: ['GET', 'POST'])]
    public function new(RequestStack $requestStack, Request $request, EntityManagerInterface $entityManager): Response
    {
        $transaction = new Transactions();
        $form = $this->createForm(Transactions1Type::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($transaction);
            $entityManager->flush();

            return $this->redirectToRoute('app_transactions_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('transactions_crud/new.html.twig', array_merge([
            'transaction' => $transaction,
            'form' => $form,
        ], $requestStack -> getSession() -> get("menuOptions")));
    }

    #[Route('/{id}', name: 'app_transactions_crud_show', methods: ['GET'])]
    public function show(RequestStack $requestStack, Transactions $transaction): Response
    {
        return $this->render('transactions_crud/show.html.twig', array_merge([
            'transaction' => $transaction,
        ], $requestStack -> getSession() -> get("menuOptions")));
    }

    #[Route('/{id}/edit', name: 'app_transactions_crud_edit', methods: ['GET', 'POST'])]
    public function edit(RequestStack $requestStack, Request $request, Transactions $transaction, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Transactions1Type::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_transactions_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('transactions_crud/edit.html.twig', array_merge([
            'transaction' => $transaction,
            'form' => $form,
        ], $requestStack -> getSession() -> get("menuOptions")));
    }

    #[Route('/{id}', name: 'app_transactions_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Transactions $transaction, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transaction->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($transaction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_transactions_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
