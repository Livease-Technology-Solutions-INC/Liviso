<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/confirmmail', name: 'confirmmail')]
    public function confirmemail(): Response
    {
        return $this->render('user/confirm-mail.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/my_account', name: 'my_account')]
    public function myAccount(): Response
    {
        return $this->render('user/myAccount.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/recoverpassword', name: 'recoverpassword')]
    public function recoverpassword(): Response
    {
        return $this->render('user/recoverpw.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    // #[Route('/lockscreen', name: 'lockscreen', methods:["GET"])]
    // public function lockscreen(): Response
    // {
    //     return $this->render('user/lock-screen.html.twig', [
    //         'controller_name' => 'UserController',
    //     ]);
    // }
}
