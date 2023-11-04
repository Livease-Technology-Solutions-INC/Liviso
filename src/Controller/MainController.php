<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home', methods:["GET"])]
    public function index(): RedirectResponse
    {
        return new RedirectResponse($this->generateUrl('account-dashboard'));
    }
    #[Route('/support', name: 'support', methods: ["GET"])]
    public function support(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('main/support.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/zoom', name: 'zoom', methods: ["GET"])]
    public function zoom(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('main/zoom.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/message', name: 'message', methods: ["GET"])]
    public function message(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('main/chat.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
