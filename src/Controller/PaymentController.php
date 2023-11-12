<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

// require 'vendor/autoload.php';

class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'app_payment')]
    public function index(): Response
    {
        return $this->render('payment/index.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }
    #[Route('/checkout', name: 'checkout')]
    public function checkout($stripeSk): Response
    {
        $stripe = new \Stripe\StripeClient($stripeSk);
        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'T-shirt',
                    ],
                    'unit_amount' => 2000,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('paymentSuccessful', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('paymentFailure', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        // Instead of using header manipulation, return a Symfony Response with a redirect
        return $this->redirect($checkout_session->url);
    }
    #[Route('/payment-successful', name: 'paymentSuccessful')]
    public function paymentSuccessful(): Response
    {
        return $this->render('payment/success.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }
    #[Route('/payment-failure', name: 'paymentFailure')]
    public function paymentFailure(): Response
    {
        return $this->render('payment/Failure.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }
}
