<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsermanagementController extends AbstractController
{
    #[Route('/usermanagement', name: 'app_usermanagement')]
    public function index(): Response
    {
        return $this->render('usermanagement/index.html.twig', [
            'controller_name' => 'UsermanagementController',
        ]);
    }
}
