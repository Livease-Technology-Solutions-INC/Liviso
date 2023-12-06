<?php

namespace App\Controller;

use App\Entity\Webhook;
use App\Form\WebhookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SettingsController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/sys_settings', name: 'system', methods: ["GET", "POST", "PUT", "DELETE"])]
    public function system(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $webhook = new Webhook();
        $form = $this->createForm(WebhookType::class, $webhook);

        // Handle form submission
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($webhook);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('system');
        }

        $repository = $this->entityManager->getRepository(Webhook::class);
        $webhooks = $repository->findAll();
        return $this->render('settings/system.html.twig', [
            'controller_name' => 'SettingsController',
            'webhooks' => $webhooks,
            'form' => $form->createView(),
        ]);
    }
    // webhook remove
    #[Route('/webhook/delete/{id}', name: 'webhook_delete', methods: ["GET", "POST", "DELETE"])]
    public function webhookDelete(Webhook $webhook): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($webhook);
        $this->entityManager->flush();
        return $this->redirectToRoute('system');
        // return new Response('post was deleted');
    }
    #[Route('/webhook/edit/{id}', name: 'webhook_edit', methods: ["GET", "POST", "PUT"])]
    public function webhookEdit(Request $request, Webhook $webhooks): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // Assuming you have a form type for editing Webhook entities
        $form = $this->createForm(WebhookType::class, $webhooks);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->getErrors(true, true));
            $this->entityManager->flush();

            // If the request is AJAX, return a JSON response
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse(['success' => true]);
            }

            return $this->redirectToRoute('system');
        }

        // If the request is AJAX, return a JSON response with form errors
        if ($request->isXmlHttpRequest()) {
            $errors = $this->getFormErrors($form);
            return new JsonResponse(['success' => false, 'errors' => $errors], 400);
        }

        return $this->render('settings/system.html.twig', [
            'form' => $form->createView(),
            'webhooks' => $webhooks,
        ]);
    }

    // Helper function to extract form errors
    private function getFormErrors(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors(true, true) as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                $childErrors = $this->getFormErrors($childForm);
                $errors = array_merge($errors, $childErrors);
            }
        }

        return $errors;
    }
    #[Route('/webhook/fetch/{id}', name: 'webhook_fetch', methods: ["GET"])]
    public function webhookFetch($id): JsonResponse
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // Fetch the Webhook entity based on $id
        $webhook = $this->entityManager->getRepository(Webhook::class)->find($id);

        // Check if the Webhook entity was found
        if (!$webhook) {
            throw $this->createNotFoundException('Webhook not found');
        }

        // Assuming you want to expose certain data for editing
        $data = [
            'id' => $webhook->getId(),
            'module' => $webhook->getModule(),
            'url' => $webhook->getUrl(),
            'method' => $webhook->getMethod(),
            // Add other fields as needed
        ];

        return new JsonResponse($data);
    }


    // webhook setting
    // #[Route('/sys_settings/webhook', name: 'webhook_create', methods: ["GET", "POST", "PUT", "DELETE"])]
    // public function webhookCreate(Request $request): Response
    // {
    //     $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    //     $webhook = new Webhook();
    //     $form = $this->createForm(WebhookType::class, $webhook);

    //     // Handle form submission
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         // Persist the entity only if the form is submitted and valid
    //         $this->entityManager->persist($webhook);
    //         $this->entityManager->flush();

    //         // Redirect after successful form submission (optional)
    //         return $this->redirectToRoute('webhook');
    //     }

    //     $repository = $this->entityManager->getRepository(Webhook::class);
    //     $webhooks = $repository->findAll();

    //     return $this->render('main/webhook.html.twig', [
    //         'controller_name' => 'MainController',
    //         'form' => $form->createView(),
    //     ]);
    // }
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
