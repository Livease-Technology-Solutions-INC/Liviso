<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CrmsystemController extends AbstractController
{
    #[Route('/crmsystem', name: 'app_crmsystem')]
    public function index(): Response
    {
        return $this->render('crmsystem/index.html.twig', [
            'controller_name' => 'CrmsystemController',
        ]);
    }
}
