<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TravelController extends AbstractController
{
    #[Route('/travel', name: 'app_travel')]
    public function index(): Response
    {
        return $this->render('travel/index.html.twig', [
            'controller_name' => 'TravelController',
        ]);
    }
}
