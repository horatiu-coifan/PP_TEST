<?php

namespace App\Controller;
use App\Entity\Login;
use App\Repository\LoginRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

   
require_once __DIR__ . '/../../vendor/autoload.php';

 
final class LoginController extends AbstractController
{
    #[Route('/', 'app_login')]
    #[Route('/login')]
    public function login(
        Request $request,
        RequestStack $requestStack,
        LoginRepository $loginRepo): Response
    {
        $username = $request -> get('username');
        $password = $request -> get('password');
        if($username && $password){
            if($login = $loginRepo -> getRecByUserPass($username, $password)){
                $session = $requestStack -> getSession();
                $session -> set("loginId", $login -> getId());
                $session -> set("userType", $login -> getType());
                $session -> set("menuOptions", [
                        "userType" => $session -> get("userType"),
                        "userName" => $username,
                        "options" => [
                            [ "name" => "Credentials", "link" => "/login/crud", "rights" => "admin"],
                            [ "name" => "County", "link" => "/county/crud" , "rights" => "user"],
                            [ "name" => "Products", "link" => "/products/crud" , "rights" => "user"],
                            [ "name" => "Clients", "link" => "/clients/crud" , "rights" => "admin"],
                            [ "name" => "Transactions", "link" => "/transactions/crud", "rights" => "user"],
                        ]
                    ]
                );
                return $this -> render('misc/dashboard.html.twig', $session -> get('menuOptions'));
            }
            else{
                $this -> addFlash(
                    'error-login',
                    'No such username/password credentials!'
                );
            }
        }

        return $this -> render('login/login.html.twig', [
            "username" => "",
            "password" => ""
        ]);
    }

    #[Route('/create')]
    public function add(LoginRepository $lR) : JsonResponse{
        $request = Request::createFromGlobals();
        $username = $request -> get('username');
        $password = $request -> get('password');

        $login = new Login();
        $login
            -> setUsername($username)
            -> setPassword(md5($password))
            -> setStatus('A')
        ;
        $lR -> save($login, true);

        return $this -> json([
            'id' => $login -> getId()
        ], Response::HTTP_OK);
    }

    #[Route('/logout', 'logout')]
    public function logout(
        Request $request,
        RequestStack $requestStack,
        LoginRepository $loginRepo
    ) : Response
    {
        $requestStack -> getSession() -> set('loginId', null);
        return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/dashboard', 'dashboard')]
    public function dashboard(
        Request $request,
        RequestStack $requestStack,
    ) : Response
    {
        $requestStack -> getSession() -> set('loginId', null);
        return $this -> render('misc/dashboard.html.twig', $requestStack -> getSession() -> get("menuOptions"));
    }

}
