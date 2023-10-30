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
        return $this->render('dashboard/account.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
    #[Route('/hrm-dashboard', name: 'hrm-dashboard')]
    public function hrmDashboard(): Response
    {
        return $this->render('dashboard/hrm.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
    #[Route('/crm-dashboard', name: 'crm-dashboard')]
    public function crmDashboard(): Response
    {
        return $this->render('dashboard/crm.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
    #[Route('/project-dashboard', name: 'project-dashboard')]
    public function projectDashboard(): Response
    {
        return $this->render('dashboard/projectDashboard.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
    #[Route('/pos-dashboard', name: 'pos-dashboard')]
    public function posDashboard(): Response
    {
        return $this->render('dashboard/posDashboard.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
    #[Route('/trading_&_services-dashboard', name: 'trading_&_services-dashboard')]
    public function index(): Response
    {
        return $this->render('dashboard/tradingAndService.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
