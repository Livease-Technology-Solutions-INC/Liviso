<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CrmsystemController extends AbstractController
{
    #[Route('/crmsystem/leads', name: 'crmsystem/leads')]
    public function leads(): Response
    {
        return $this->render('crmsystem/leads.html.twig', [
            'controller_name' => 'CrmsystemController',
        ]);
    }
    #[Route('/crmsystem/deals', name: 'crmsystem/deals')]
    public function deals(): Response
    {
        return $this->render('crmsystem/deals.html.twig', [
            'controller_name' => 'CrmsystemController',
        ]);
    }
    #[Route('/crmsystem/form_builder', name: 'crmsystem/form_builder')]
    public function formBuilder(): Response
    {
        return $this->render('crmsystem/formBuilder.html.twig', [
            'controller_name' => 'CrmsystemController',
        ]);
    }
    #[Route('/crmsystem/contract', name: 'crmsystem/contract')]
    public function contract(): Response
    {
        return $this->render('crmsystem/contract.html.twig', [
            'controller_name' => 'CrmsystemController',
        ]);
    }
    #[Route('/crmsystem/crm_system_setup', name: 'crmsystem/crm_system_setup')]
    public function crmSystemSetup(): Response
    {
        return $this->render('crmsystem/crmSystemSetup.html.twig', [
            'controller_name' => 'CrmsystemController',
        ]);
    }
}
