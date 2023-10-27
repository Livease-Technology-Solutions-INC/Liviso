<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/login', name: 'login', methods:["POST"])]
    public function login(): Response
    {
        return $this->render('user/login.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/register', name: 'register', methods:["POST"])]
    public function register(): Response
    {
        return $this->render('user/register.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/confirmmail', name: 'confirmmail', methods:["POST"])]
    public function confirmemail(): Response
    {
        return $this->render('user/confirm-mail.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/logout', name: 'logout', methods:["GET"])]
    public function logout(): Response
    {
        return $this->render('user/logout.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/recoverpassword', name: 'recoverpassword', methods:["POST"])]
    public function recoverpassword(): Response
    {
        return $this->render('user/recoverpw.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/lockscreen', name: 'lockscreen', methods:["GET"])]
    public function lockscreen(): Response
    {
        return $this->render('user/lock-screen.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
