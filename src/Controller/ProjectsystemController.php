<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectsystemController extends AbstractController
{
    #[Route('/projectsystem', name: 'app_projectsystem')]
    public function index(): Response
    {
        return $this->render('projectsystem/index.html.twig', [
            'controller_name' => 'ProjectsystemController',
        ]);
    }
}
