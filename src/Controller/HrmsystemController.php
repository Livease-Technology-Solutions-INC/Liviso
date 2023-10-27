<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HrmsystemController extends AbstractController
{
    #[Route('/hrmsystem', name: 'app_hrmsystem')]
    public function index(): Response
    {
        return $this->render('hrmsystem/index.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
}
