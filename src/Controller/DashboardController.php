<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/account-dashboard', name: 'account-dashboard')]
    public function accountDashboard(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('dashboard/account.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
    #[Route('/hrm-dashboard', name: 'hrm-dashboard')]
    public function hrmDashboard(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('dashboard/hrm.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
    #[Route('/crm-dashboard', name: 'crm-dashboard')]
    public function crmDashboard(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('dashboard/crm.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
    #[Route('/project-dashboard', name: 'project-dashboard')]
    public function projectDashboard(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('dashboard/projectDashboard.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
    #[Route('/pos-dashboard', name: 'pos-dashboard')]
    public function posDashboard(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('dashboard/posDashboard.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
    #[Route('/workflowSystem-dashboard', name: 'workflowSystem-dashboard')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('dashboard/workflowSystem.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
