<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsystemController extends AbstractController
{
    #[Route('/productsystem/product&services', name: 'productsystem/product_services')]
    public function product_servidces(): Response
    {
        return $this->render('productsystem/product_services.html.twig', [
            'controller_name' => 'ProductsystemController',
        ]);
    }
    #[Route('/productsystem/product_stock', name: 'productsystem/product_stock')]
    public function product_stock(): Response
    {
        return $this->render('productsystem/product_stock.html.twig', [
            'controller_name' => 'ProductsystemController',
        ]);
    }
}
