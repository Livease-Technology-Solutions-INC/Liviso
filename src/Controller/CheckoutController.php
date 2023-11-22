<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    #[Route('/small', name: 'small')]
    public function small(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('checkout/small.html.twig', [
            'controller_name' => 'CheckoutController',
        ]);
    }
    #[Route('/medium', name: 'medium')]
    public function medium(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('checkout/medium.html.twig', [
            'controller_name' => 'CheckoutController',
        ]);
    }
    #[Route('/enterprice', name: 'enterprice')]
    public function enterprice(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('checkout/enterprice.html.twig', [
            'controller_name' => 'CheckoutController',
        ]);
    }
    #[Route('/ultra', name: 'ultra')]
    public function ultra(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('checkout/ultra.html.twig', [
            'controller_name' => 'CheckoutController',
        ]);
    }
    #[Route('/red/card', name: 'red_card')]
    public function redCard(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('checkout/redCard.html.twig', [
            'controller_name' => 'CheckoutController',
        ]);
    }
    #[Route('/red/contact', name: 'red_contact')]
    public function redContact(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('checkout/redContact.html.twig', [
            'controller_name' => 'CheckoutController',
        ]);
    }
    #[Route('/purple/card', name: 'purple_card')]
    public function purpleCard(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('checkout/purpleCard.html.twig', [
            'controller_name' => 'CheckoutController',
        ]);
    }
    #[Route('/purple/contact', name: 'purple_contact')]
    public function purpleContact(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('checkout/purpleContact.html.twig', [
            'controller_name' => 'CheckoutController',
        ]);
    }
}
