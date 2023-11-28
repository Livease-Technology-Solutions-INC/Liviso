<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkflowSystemController extends AbstractController
{
    #[Route('/workflowsystem/customercreation', name: 'workflowsystem/customercreation')]
    public function customerCreation(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('workflow_system/customerCreation.html.twig', [
            'controller_name' => 'WorkflowSystemController',
        ]);
    }
    #[Route('/workflowsystem/enquirycreation', name: 'workflowsystem/enquirycreation')]
    public function enquiryCreation(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('workflow_system/enquiryCreation.html.twig', [
            'controller_name' => 'WorkflowSystemController',
        ]);
    }
    #[Route('/workflowsystem/salesorder', name: 'workflowsystem/salesorder')]
    public function salesOrder(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('workflow_system/salesOrder.html.twig', [
            'controller_name' => 'WorkflowSystemController',
        ]);
    }
    #[Route('/workflowsystem/newproductrequest', name: 'workflowsystem/newproductrequest')]
    public function newProductRequest(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('workflow_system/newProductRequest.html.twig', [
            'controller_name' => 'WorkflowSystemController',
        ]);
    }
    #[Route('/workflowsystem/grnocal', name: 'workflowsystem/grnlocal')]
    public function grnLocal(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('workflow_system/grnLocal.html.twig', [
            'controller_name' => 'WorkflowSystemController',
        ]);
    }
    #[Route('/workflowsystem/deliveryorder', name: 'workflowsystem/deliveryorder')]
    public function deliveryOrder(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('workflow_system/deliveryOrder.html.twig', [
            'controller_name' => 'WorkflowSystemController',
        ]);
    }
    #[Route('/workflowsystem/invoicegeneration', name: 'workflowsystem/invoicegeneration')]
    public function invoiceGeneration(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('workflow_system/invoiceGeneration.html.twig', [
            'controller_name' => 'WorkflowSystemController',
        ]);
    }
    #[Route('/workflowsystem/servicerequest', name: 'workflowsystem/servicerequest')]
    public function serviceRequest(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('workflow_system/serviceRequest.html.twig', [
            'controller_name' => 'WorkflowSystemController',
        ]);
    }
    #[Route('/workflowsystem/serviceitemdeliverynote', name: 'workflowsystem/serviceitemdeliverynote')]
    public function serviceItemDeliveryNote(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('workflow_system/serviceItemDeliveryNote.html.twig', [
            'controller_name' => 'WorkflowSystemController',
        ]);
    }
    #[Route('/workflowsystem/suppliercreation', name: 'workflowsystem/suppliercreation')]
    public function supplierCreation(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('workflow_system/supplierCreation.html.twig', [
            'controller_name' => 'WorkflowSystemController',
        ]);
    }
    #[Route('/workflowsystem/productmaster', name: 'workflowsystem/productmaster')]
    public function productMaster(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('workflow_system/productMaster.html.twig', [
            'controller_name' => 'WorkflowSystemController',
        ]);
    }
    #[Route('/workflowsystem/purchaseorder', name: 'workflowsystem/purchaseorder')]
    public function purchaseOrder(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('workflow_system/purchaseOrder.html.twig', [
            'controller_name' => 'WorkflowSystemController',
        ]);
    }
    #[Route('/workflowsystem/qcrequest', name: 'workflowsystem/qcrequest')]
    public function qcRequest(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('workflow_system/qcRequest.html.twig', [
            'controller_name' => 'WorkflowSystemController',
        ]);
    }
    #[Route('/workflowsystem/shippingorder', name: 'workflowsystem/shippingorder')]
    public function shippingOrder(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('workflow_system/shippingOrder.html.twig', [
            'controller_name' => 'WorkflowSystemController',
        ]);
    }
    #[Route('/workflowsystem/shippingbill', name: 'workflowsystem/shippingbill')]
    public function shippingBill(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('workflow_system/shippingBill.html.twig', [
            'controller_name' => 'WorkflowSystemController',
        ]);
    }
    #[Route('/workflowsystem/grn', name: 'workflowsystem/grn')]
    public function grn(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('workflow_system/grn.html.twig', [
            'controller_name' => 'WorkflowSystemController',
        ]);
    }
    #[Route('/workflowsystem/costingsheet', name: 'workflowsystem/costingsheet')]
    public function costingSheet(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('workflow_system/costingSheet.html.twig', [
            'controller_name' => 'WorkflowSystemController',
        ]);
    }
    #[Route('/workflowsystem/paymentreceipt', name: 'workflowsystem/paymentreceipt')]
    public function paymentReceipt(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('workflow_system/paymentReceipt.html.twig', [
            'controller_name' => 'WorkflowSystemController',
        ]);
    }
    #[Route('/workflowsystem/advancepayment', name: 'workflowsystem/advancepayment')]
    public function advancePayment(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('workflow_system/advancePayment.html.twig', [
            'controller_name' => 'WorkflowSystemController',
        ]);
    }
    #[Route('/workflowsystem/hr', name: 'workflowsystem/hr')]
    public function hr(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('workflow_system/hr.html.twig', [
            'controller_name' => 'WorkflowSystemController',
        ]);
    }
    #[Route('/workflowsystem/operations', name: 'workflowsystem/operations')]
    public function operations(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('workflow_system/operations.html.twig', [
            'controller_name' => 'WorkflowSystemController',
        ]);
    }
    #[Route('/workflowsystem/IT', name: 'workflowsystem/IT')]
    public function IT(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('workflow_system/IT.html.twig', [
            'controller_name' => 'WorkflowSystemController',
        ]);
    }
}
