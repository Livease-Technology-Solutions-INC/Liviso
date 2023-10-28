<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsermanagementController extends AbstractController
{
    #[Route('/user', name: 'user')]
    public function user(): Response
    {
        return $this->render('usermanagement/user.html.twig', [
            'controller_name' => 'UsermanagementController',
        ]);
    }
    #[Route('/role', name: 'role')]
    public function role(): Response
    {
        return $this->render('usermanagement/client.html.twig', [
            'controller_name' => 'UsermanagementController',
        ]);
    }
    #[Route('/client', name: 'client')]
    public function client(): Response
    {
        return $this->render('usermanagement/role.html.twig', [
            'controller_name' => 'UsermanagementController',
        ]);
    }
}
