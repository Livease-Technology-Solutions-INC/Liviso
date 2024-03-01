<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\POSSystem\Purchase;
use App\Entity\POSSystem\WareHouse;
use App\Form\POSSystem\PurchaseType;
use App\Form\POSSystem\WareHouseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PossystemController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/pos/warehouse/{id}', name: 'pos_system/warehouse')]
    public function warehouse(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $wareHouse = new WareHouse();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $wareHouse->setUser($user);
        $form = $this->createForm(WareHouseType::class, $wareHouse, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($wareHouse);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('pos_system/warehouse',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(warehouse::class);
        $wareHouses = $repository->findBy(['user' => $currentUser]);

        return $this->render('possystem/warehouse.html.twig', [
            'controller_name' => 'PossystemController',
            'warehouses' => $wareHouses,
            'form' => $form->createView(),
        ]);
    }
     
    //delete warehouse
    #[Route('/possystem/warehouse/{id}/delete/{user_id}', name: 'warehouse_delete', methods: ["GET", "POST"])]
    public function warehouseDelete(warehouse $wareHouse, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($wareHouse);
        $this->entityManager->flush();
        return $this->redirectToRoute('pos_system/warehouse', ['id' => $user_id]);
    }

    // edit purchase
    #[Route("/pos_system/warehouse/{id}/edit/{user_id}", name: "warehouse_edit", methods: ["GET", "PUT", "POST"])]
    public function warehouseEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(warehouse::class);
        $warehouse = $repository->find($id);

        if (!$warehouse) {
            throw $this->createNotFoundException('warehouse not found');
        }

        $form = $this->createForm(WareHouseType::class, $warehouse,  ['current_user' => $this->getUser()]);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $warehouse = $form->getData();
                $this->entityManager->persist($warehouse);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('pos_system/warehouse', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(warehouse::class);
        $wareHouses = $repository->findBy(['user' => $currentUser]);

        return $this->render('pos_system/edit/warehouse.html.twig', [
            'controllername' => 'HrmsystemController',
            'form' => $form->createView(),
            'wareHouses' => $wareHouses,
        ]);
    }


    #[Route('/pos/purchase/{id}', name: 'pos_system/purchase')]
    public function purchase(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $purchase = new Purchase();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $purchase->setUser($user);
        $form = $this->createForm(PurchaseType::class, $purchase, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($purchase);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('pos_system/purchase',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(purchase::class);
        $purchases = $repository->findBy(['user' => $currentUser]);

        return $this->render('possystem/purchase.html.twig', [
            'controller_name' => 'PossystemController',
            'purchases' => $purchases,
            'form' => $form->createView(),
        ]);
    }
    // delete purchase
    #[Route('/possystem/purchase/{id}/delete/{user_id}', name: 'purchase_delete', methods: ["GET", "POST"])]
    public function purchaseDelete(purchase $purchase, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($purchase);
        $this->entityManager->flush();
        return $this->redirectToRoute('pos_system/purchase', ['id' => $user_id]);
    }
    // edit purchase
    #[Route("/pos_system/purchase/{id}/edit/{user_id}", name: "purchase_edit", methods: ["GET", "PUT", "POST"])]
    public function purchaseEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(purchase::class);
        $purchase = $repository->find($id);

        if (!$purchase) {
            throw $this->createNotFoundException('purchase not found');
        }

        $form = $this->createForm(purchaseType::class, $purchase,  ['current_user' => $this->getUser()]);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $purchase = $form->getData();
                $this->entityManager->persist($purchase);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('pos_system/purchase', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(purchase::class);
        $purchases = $repository->findBy(['user' => $currentUser]);

        return $this->render('pos_system/edit/purchase.html.twig', [
            'controllername' => 'HrmsystemController',
            'form' => $form->createView(),
            'purchases' => $purchases,
        ]);
    }
    #[Route('/pos/add_pos', name: 'pos_system/add_pos')]
    public function add_pos(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('possystem/add_pos.html.twig', [
            'controller_name' => 'PossystemController',
        ]);
    }
    #[Route('/pos/pos', name: 'pos_system/pos')]
    public function pos(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('possystem/pos.html.twig', [
            'controller_name' => 'PossystemController',
        ]);
    }
    #[Route('/pos/print_barcode', name: 'pos_system/print_barcode')]
    public function print_barcode(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('possystem/print_barcode.html.twig', [
            'controller_name' => 'PossystemController',
        ]);
    }
    #[Route('/pos/print_setting', name: 'pos_system/print_setting')]
    public function print_setting(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('possystem/print_setting.html.twig', [
            'controller_name' => 'PossystemController',
        ]);
    }
}
