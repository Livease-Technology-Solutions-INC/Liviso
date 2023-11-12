<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentselectionController extends AbstractController
{
    #[Route('/paymentselection', name: 'paymentSelection')]
    public function index(): Response
    {
        return $this->render('paymentselection/index.html.twig', [
            'controller_name' => 'PaymentselectionController',
        ]);
    }
}
