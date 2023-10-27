<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PossystemController extends AbstractController
{
    #[Route('/pos/warehouse', name: 'pos_system/warehouse')]
    public function warehouse(): Response
    {
        return $this->render('possystem/warehouse.html.twig', [
            'controller_name' => 'PossystemController',
        ]);
    }
    #[Route('/pos/purchase', name: 'pos_system/purchase')]
    public function purchase(): Response
    {
        return $this->render('possystem/purchase.html.twig', [
            'controller_name' => 'PossystemController',
        ]);
    }
    #[Route('/pos/add_pos', name: 'pos_system/add_pos')]
    public function add_pos(): Response
    {
        return $this->render('possystem/add_pos.html.twig', [
            'controller_name' => 'PossystemController',
        ]);
    }
    #[Route('/pos/pos', name: 'pos_system/pos')]
    public function pos(): Response
    {
        return $this->render('possystem/pos.html.twig', [
            'controller_name' => 'PossystemController',
        ]);
    }
    #[Route('/pos/print_barcode', name: 'pos_system/print_barcode')]
    public function print_barcode(): Response
    {
        return $this->render('possystem/print_barcode.html.twig', [
            'controller_name' => 'PossystemController',
        ]);
    }
    #[Route('/pos/print_setting', name: 'pos_system/print_setting')]
    public function print_setting(): Response
    {
        return $this->render('possystem/print_setting.html.twig', [
            'controller_name' => 'PossystemController',
        ]);
    }
}
