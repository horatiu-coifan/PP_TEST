<?php

namespace App\Controller;

use App\Entity\Login;
use App\Form\LoginType;
use App\Repository\LoginRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/login/crud')]
final class LoginCrudController extends AbstractController
{
    #[Route(name: 'app_login_crud_index', methods: ['GET'])]
    public function index(RequestStack $requestStack, LoginRepository $loginRepository): Response
    {
        return $this->render('login_crud/index.html.twig', array_merge([
            'logins' => $loginRepository->findAll(),
        ], $requestStack -> getSession() -> get('menuOptions')));
    }

    #[Route('/new', name: 'app_login_crud_new', methods: ['GET', 'POST'])]
    public function new(RequestStack $requestStack, Request $request, EntityManagerInterface $entityManager): Response
    {
        $login = new Login();
        $form = $this->createForm(LoginType::class, $login);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $login -> setPassword( md5($login -> getPassword()) );
            $entityManager->persist($login);
            $entityManager->flush();

            return $this->redirectToRoute('app_login_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('login_crud/new.html.twig', array_merge([
            'login' => $login,
            'form' => $form,
        ], $requestStack -> getSession() -> get('menuOptions')));
    }

    #[Route('/{id}', name: 'app_login_crud_show', methods: ['GET'])]
    public function show(RequestStack $requestStack, Login $login): Response
    {
        return $this->render('login_crud/show.html.twig', array_merge([
            'login' => $login,
        ], $requestStack -> getSession() -> get('menuOptions')));
    }

    #[Route('/{id}/edit', name: 'app_login_crud_edit', methods: ['GET', 'POST'])]
    public function edit(RequestStack $requestStack, Request $request, Login $login, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LoginType::class, $login);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $login -> setPassword( md5($login -> getPassword()) );
            $entityManager->flush();

            return $this->redirectToRoute('app_login_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('login_crud/edit.html.twig', array_merge([
            'login' => $login,
            'form' => $form,
        ], $requestStack -> getSession() -> get('menuOptions')));
    }

    #[Route('/{id}', name: 'app_login_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Login $login, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$login->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($login);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_login_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
