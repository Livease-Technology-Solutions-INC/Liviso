<?php

namespace App\Controller;

use App\Entity\CRMSystem\Contract;
use App\Entity\CRMSystem\FormBuilder;
use App\Entity\User;
use App\Form\CRMSystem\ContractType;
use App\Form\CRMSystem\FormBuilderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CrmsystemController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/crmsystem/leads', name: 'crmsystem/leads')]
    public function leads(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('crmsystem/leads.html.twig', [
            'controller_name' => 'CrmsystemController',
        ]);
    }
    #[Route('/crmsystem/deals', name: 'crmsystem/deals')]
    public function deals(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('crmsystem/deals.html.twig', [
            'controller_name' => 'CrmsystemController',
        ]);
    }
    #[Route('/crmsystem/form_builder{id}', name: 'crmsystem/form_builder')]
    public function formBuilder(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);

        $formBuilder = new FormBuilder();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $formBuilder->setUser($user);
        $form = $this->createForm(FormBuilderType::class, $formBuilder, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($formBuilder);
            $this->entityManager->flush();

            // Redirect after successful form submission
            return $this->redirectToRoute('crmsystem/form_builder',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(formBuilder::class);
        $formBuilders = $repository->findBy(['user' => $currentUser]);

        return $this->render('crmsystem/formBuilder.html.twig', [
            'controller_name' => 'CrmsystemController',
            'formBuilders' => $formBuilders,
            'form' => $form->createView(),
        ]);
    }

     //delete form Builder
     #[Route('/crmsystem/form_builder/{id}/delete/{user_id}', name: 'form_builder_delete', methods: ["GET", "POST"])]
     public function formBuilderDelete(formBuilder $formBuilder, int $id, int $user_id): Response
     {
         $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
         if (!$formBuilder) {
             throw $this->createNotFoundException('form builder not found');
         }
 
         $this->entityManager->remove($formBuilder);
         $this->entityManager->flush();
 
         return $this->redirectToRoute('crmsystem/form_builder', ['id' => $user_id]);
     }

    //edit form builder
    #[Route("/accountingsystem/form_builder/{id}/edit/{user_id}", name: "form_builder_edit", methods: ["GET", "PUT", "POST"])]
    public function formBuilderEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(formBuilder::class);
        $formBuilder = $repository->find($id);

        if (!$formBuilder) {
            throw $this->createNotFoundException('form builder not found');
        }

        $form = $this->createForm(formBuilder::class, $formBuilder,  ['current_user' => $this->getUser()]);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $formBuilder = $form->getData();
                $this->entityManager->persist($formBuilder);
                $this->entityManager->flush();

                // Redirect after successful form submission
                return $this->redirectToRoute('accountingsystem/form_builder', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }

        $repository = $this->entityManager->getRepository(formBuilder::class);
        $formBuilders = $repository->findBy(['user' => $currentUser]);

        return $this->render('accountingsystem/edit/contract.html.twig', [
            'controller_name' => 'AccountingsystemController',
            'form' => $form->createView(),
            'formBuilder' => $formBuilders,
        ]);
    }

    #[Route('/crmsystem/contract{id}', name: 'crmsystem/contract')]
    public function contract(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $contract = new Contract();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $contract->setUser($user);
        $form = $this->createForm(ContractType::class, $contract, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($contract);
            $this->entityManager->flush();

            // Redirect after successful form submission
            return $this->redirectToRoute('crmsystem/contract',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(contract::class);
        $contracts = $repository->findBy(['user' => $currentUser]);


        return $this->render('crmsystem/contract.html.twig', [
            'controller_name' => 'CrmsystemController',
            'contracts' => $contracts,
            'form' => $form->createView(),
        ]);
    }
    //delete contract
    #[Route('/crmsystem/contract/{id}/delete/{user_id}', name: 'contract_delete', methods: ["GET", "POST"])]
    public function contractDelete(contract $contract, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!$contract) {
            throw $this->createNotFoundException('contract not found');
        }

        $this->entityManager->remove($contract);
        $this->entityManager->flush();

        return $this->redirectToRoute('crmsystem/contract', ['id' => $user_id]);
    }

    //edit contract
    #[Route("/accountingsystem/contract/{id}/edit/{user_id}", name: "contract_edit", methods: ["GET", "PUT", "POST"])]
    public function contractEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(contract::class);
        $contract = $repository->find($id);

        if (!$contract) {
            throw $this->createNotFoundException('contract not found');
        }

        $form = $this->createForm(contract::class, $contract,  ['current_user' => $this->getUser()]);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $contract = $form->getData();
                $this->entityManager->persist($contract);
                $this->entityManager->flush();

                // Redirect after successful form submission
                return $this->redirectToRoute('accountingsystem/contract', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }

        $repository = $this->entityManager->getRepository(contract::class);
        $contracts = $repository->findBy(['user' => $currentUser]);

        return $this->render('accountingsystem/edit/contract.html.twig', [
            'controller_name' => 'AccountingsystemController',
            'form' => $form->createView(),
            'contracts' => $contracts,
        ]);
    }


    #[Route('/crmsystem/crm_system_setup', name: 'crmsystem/crm_system_setup')]
    public function crmSystemSetup(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('crmsystem/crmSystemSetup.html.twig', [
            'controller_name' => 'CrmsystemController',
        ]);
    }
}
