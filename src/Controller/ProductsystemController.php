<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsystemController extends AbstractController
{
    #[Route('/productsystem', name: 'app_productsystem')]
    public function index(): Response
    {
        return $this->render('productsystem/index.html.twig', [
            'controller_name' => 'ProductsystemController',
        ]);
    }
}
