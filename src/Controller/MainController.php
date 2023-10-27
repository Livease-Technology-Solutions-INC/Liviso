<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home', methods:["GET"])]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/support', name: 'support', methods: ["GET"])]
    public function support(): Response
    {
        return $this->render('main/support.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/zoom', name: 'zoom', methods: ["GET"])]
    public function zoom(): Response
    {
        return $this->render('main/zoom.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/message', name: 'message', methods: ["GET"])]
    public function message(): Response
    {
        return $this->render('main/chat.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
