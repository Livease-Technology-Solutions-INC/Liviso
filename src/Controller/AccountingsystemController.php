<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountingsystemController extends AbstractController
{
    #[Route('/accountingsystem', name: 'app_accountingsystem')]
    public function index(): Response
    {
        return $this->render('accountingsystem/index.html.twig', [
            'controller_name' => 'AccountingsystemController',
        ]);
    }
}
