<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\WorkFlowSystem\Sales\CustomerCreate;
use App\Entity\WorkFlowSystem\Sales\EnquiryCreation;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\WorkFlowSystem\Sales\CustomerCreateType;
use App\Form\WorkFlowSystem\Sales\EnquiryCreateType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WorkflowSystemController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/workflowsystem/customercreation{id}', name: 'workflowsystem/customercreation')]
    public function customerCreation(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $customerCreate = new CustomerCreate();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $customerCreate->setUser($user);
        $form = $this->createForm(CustomerCreateType::class, $customerCreate, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFiles = $request->files->get('customer_create');
        
            foreach (['tradeLicense', 'partnerPassportId'] as $field) {
                $file = $uploadedFiles[$field] ?? null;
        
                if ($file instanceof UploadedFile) {
                    $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                    try {
                        $file->move(
                            $this->getParameter('support_dir'),
                            $fileName
                        );
                    } catch (\Exception $e) {
                        $this->addFlash('error', 'There was an issue with one of the files');
                        return $this->redirectToRoute('customercreation');
                    }
                    // Set the filename in the entity
                    $setter = 'set' . ucfirst($field);
                    $customerCreate->$setter($fileName);
                }
            }
                  
            $this->entityManager->persist($customerCreate);
            $this->entityManager->flush();

            // Redirect after successful form submission
            return $this->redirectToRoute('workflowsystem/customercreation',  ['id' => $id]);
        }
        $repository = $this->entityManager->getRepository(CustomerCreate::class);
        $customerCreates = $repository->findBy(['user' => $currentUser]);

        return $this->render('workflow_system/customerCreation.html.twig', [
            'controller_name' => 'WorkflowSystemController',
            'customerCreates' => $customerCreates,
            'form' => $form->createView(),
        ]);
    }

    //delete customer creation
    #[Route('/workflowsystem/customercreation/{id}/delete/{user_id}', name: 'customer_create_delete', methods: ["GET", "POST"])]
    public function customerCreateDelete(CustomerCreate $customerCreate, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!$customerCreate) {
            throw $this->createNotFoundException('customer create not found');
        }

        $this->entityManager->remove($customerCreate);
        $this->entityManager->flush();

        return $this->redirectToRoute('workflowsystem/customercreation', ['id' => $user_id]);
    }

    #[Route("/workflowsystem/customercreation/{id}/edit/{user_id}", name: "customer_create_edit", methods: ["GET", "PUT", "POST"])]
    public function customerCreateEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(CustomerCreate::class);
        $customerCreate = $repository->find($id);

        if (!$customerCreate) {
            throw $this->createNotFoundException('customer create not found');
        }

        $form = $this->createForm(CustomerCreateType::class, $customerCreate,  ['current_user' => $this->getUser()]);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $customerCreate = $form->getData();
                $this->entityManager->persist($customerCreate);
                $this->entityManager->flush();

                // Redirect after successful form submission
                return $this->redirectToRoute('workflowsystem/customercreation', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(CustomerCreate::class);
        $customerCreates = $repository->findBy(['user' => $currentUser]);

        return $this->render('workflowsystem/edit/customerCreation.html.twig', [
            'controllername' => 'ProductsystemController',
            'form' => $form->createView(),
            'customerCreates' => $customerCreates,
        ]);
    }

    #[Route('/workflowsystem/enquirycreation{id}', name: 'workflowsystem/enquirycreation')]
    public function enquiryCreation(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $enquiryCreation = new EnquiryCreation();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $enquiryCreation->setUser($user);
        $form = $this->createForm(EnquiryCreateType::class, $enquiryCreation, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($enquiryCreation);
            $this->entityManager->flush();

            // Redirect after successful form submission
            return $this->redirectToRoute('workflowsystem/enquirycreation',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(enquiryCreation::class);
        $enquiryCreations = $repository->findBy(['user' => $currentUser]);

        return $this->render('workflow_system/enquiryCreation.html.twig', [
            'controller_name' => 'WorkflowSystemController',
            'enquiryCreations' => $enquiryCreations,
            'form' => $form->createView(),
        ]);
    }

    //delete enquiry creation
    #[Route('/workflowsystem/enquirycreation/{id}/delete/{user_id}', name: 'enquiry_creation_delete', methods: ["GET", "POST"])]
    public function enquiryCreationDelete(enquiryCreation $enquirycreation, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!$enquirycreation) {
            throw $this->createNotFoundException('enquirycreation not found');
        }

        $this->entityManager->remove($enquirycreation);
        $this->entityManager->flush();

        return $this->redirectToRoute('workflowsystem/enquirycreation', ['id' => $user_id]);
    }

    //edit enquiry creation
    #[Route("/workflowsystem/enquirycreation/{id}/edit/{user_id}", name: "enquiry_creation_edit", methods: ["GET", "PUT", "POST"])]
    public function enquiryCreationEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(enquiryCreation::class);
        $enquiryCreation = $repository->find($id);

        if (!$enquiryCreation) {
            throw $this->createNotFoundException('enquiry creation not found');
        }

        $form = $this->createForm(EnquiryCreateType::class, $enquiryCreation,  ['current_user' => $this->getUser()]);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $enquiryCreation = $form->getData();
                $this->entityManager->persist($enquiryCreation);
                $this->entityManager->flush();

                // Redirect after successful form submission
                return $this->redirectToRoute('workflowsystem/enquirycreation', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }

        $repository = $this->entityManager->getRepository(enquiryCreation::class);
        $enquiryCreations = $repository->findBy(['user' => $currentUser]);

        return $this->render('accountingsystem/edit/financialGoal.html.twig', [
            'controller_name' => 'WorkflowSystemController',
            'form' => $form->createView(),
            'enquiryCreations' => $enquiryCreations,
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
