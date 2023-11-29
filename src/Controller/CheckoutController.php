<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    #[Route('/checkout/small', name: 'small')]
    public function small(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('checkout/small.html.twig', [
            'controller_name' => 'CheckoutController',
        ]);
    }
    #[Route('/checkout/medium', name: 'medium')]
    public function medium(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('checkout/medium.html.twig', [
            'controller_name' => 'CheckoutController',
        ]);
    }
    #[Route('/checkout/enterprice', name: 'enterprice')]
    public function enterprice(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('checkout/enterprice.html.twig', [
            'controller_name' => 'CheckoutController',
        ]);
    }
    #[Route('/checkout/ultra', name: 'ultra')]
    public function ultra(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('checkout/ultra.html.twig', [
            'controller_name' => 'CheckoutController',
        ]);
    }

    #[Route('/checkout/red/contact', name: 'red_contact')]
    public function redContact(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('checkout/redContact.html.twig', [
            'controller_name' => 'CheckoutController',
        ]);
    }

    #[Route('/checkout/purple/contact', name: 'purple_contact')]
    public function purpleContact(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('checkout/purpleContact.html.twig', [
            'controller_name' => 'CheckoutController',
        ]);
    }
}
