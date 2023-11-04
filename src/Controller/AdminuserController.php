<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminuserController extends AbstractController
{
    #[Route('/adminuser', name: 'app_adminuser')]
    public function index(): Response
    {
        return $this->render('adminuser/index.html.twig', [
            'controller_name' => 'AdminuserController',
        ]);
    }
}
