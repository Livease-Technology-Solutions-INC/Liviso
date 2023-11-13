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
    #[Route('/checkout/{$plan}', name: 'checkout')]
    public function checkout($stripeSk, $plan): Response
    {
        // Your logic to determine unit_amount based on $plan
        $unitAmount = $this->getUnitAmountForPlan($plan);

        $stripe = new \Stripe\StripeClient($stripeSk);
        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $unitAmount['product'],
                    ],
                    'unit_amount' => $unitAmount['price'],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('paymentSuccessful', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('paymentFailure', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $this->redirect($checkout_session->url);
        // dd($checkout_session);

    }
    private function getUnitAmountForPlan($plan)
    {
        // Your logic to determine unit_amount based on $plan
        // This is just a placeholder, replace it with your actual logic
        if ($plan === 'small') {
            return ["price" => 49, "product" => "small"]; 
        } if($plan === "medium") {
            return ["price" => 99, "product" => "medium"]; 
        } if($plan === "enterprice"){
            return ["price" => 199, "product" => "enterprice"];
        }if($plan === "ultra"){
            return ["price" => 299, "product" => "ultra"];
        }
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
