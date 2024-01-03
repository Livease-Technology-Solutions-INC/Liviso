<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RequiredbusinesscredentialsController extends AbstractController
{
    #[Route('/requiredbusinesscredentials', name: 'app_requiredbusinesscredentials')]
    public function index(Request $request, int $id): Response
    {

        return $this->render('requiredbusinesscredentials/required_business_credentials.html.twig', [
            'controller_name' => 'RequiredbusinesscredentialsController',
        ]);
    }
}
