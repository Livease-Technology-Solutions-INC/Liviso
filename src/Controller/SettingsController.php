<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SettingsController extends AbstractController
{
    #[Route('/sys_settings', name: 'system')]
    public function system(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('settings/system.html.twig', [
            'controller_name' => 'SettingsController',
        ]);
    }
    #[Route('/settings/setup_subcription_plan', name: 'setup_subcription_plan')]
    public function setupSubcriptionPlan(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('settings/setupSubcriptionPlan.html.twig', [
            'controller_name' => 'SettingsController',
        ]);
    }
    #[Route('/settings/Order', name: 'order')]
    public function order(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('settings/order.html.twig', [
            'controller_name' => 'SettingsController',
        ]);
    }
}
