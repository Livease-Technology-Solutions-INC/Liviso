<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ProductsSystem\ProductServices;
use App\Form\ProductsSystem\ProductServicesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductsystemController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/productsystem/product&services{id}', name: 'productsystem/product_services')]
    public function product_services(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $productService = new ProductServices();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $productService->setUser($user);
        $form = $this->createForm(ProductServicesType::class, $productService, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $request->files->get(key:'product_services')['productImage'] ?? null;
            
            if ($file) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('support_dir'),
                        $fileName
                    );
                } catch (\Exception $e) {
                    $this->addFlash('error', 'There was an issue with the image');
                    return $this->redirectToRoute('product_services');
                }
                $productService->setProductImage($fileName);
            }

            $this->entityManager->persist($productService);
            $this->entityManager->flush();

            // Redirect after successful form submission
            return $this->redirectToRoute('productsystem/product_services',  ['id' => $id]);
        }
        $repository = $this->entityManager->getRepository(ProductServices::class);
        $productServices = $repository->findBy(['user' => $currentUser]);

        return $this->render('productsystem/product_services.html.twig', [
            'controller_name' => 'ProductsystemController',
            'productServices' => $productServices,
            'form' => $form->createView(),
        ]);
    }

    //delete product services
    #[Route('/productsystem/product&services/{id}/delete/{user_id}', name: 'product_services_delete', methods: ["GET", "POST"])]
    public function productServicesDelete(productServices $productService, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!$productService) {
            throw $this->createNotFoundException('product service not found');
        }

        $this->entityManager->remove($productService);
        $this->entityManager->flush();

        return $this->redirectToRoute('productsystem/product_services', ['id' => $user_id]);
    }

    #[Route("/productsystem/product&services/{id}/edit/{user_id}", name: "product_services_edit", methods: ["GET", "PUT", "POST"])]
    public function productServicesEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(ProductServices::class);
        $productService = $repository->find($id);

        if (!$productService) {
            throw $this->createNotFoundException('product service not found');
        }

        $form = $this->createForm(ProductServicesType::class, $productService,  ['current_user' => $this->getUser()]);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $productService = $form->getData();
                $this->entityManager->persist($productService);
                $this->entityManager->flush();

                // Redirect after successful form submission
                return $this->redirectToRoute('productsystem/product_services', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(productServices::class);
        $productServices = $repository->findBy(['user' => $currentUser]);

        return $this->render('productsystem/edit/productServices.html.twig', [
            'controllername' => 'ProductsystemController',
            'form' => $form->createView(),
            'productServices' => $productServices,
        ]);
    }

    #[Route('/productsystem/product_stock', name: 'productsystem/product_stock')]
    public function product_stock(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('productsystem/product_stock.html.twig', [
            'controller_name' => 'ProductsystemController',
        ]);
    }
}
