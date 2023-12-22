<?php

namespace App\Controller;

use App\Entity\User;
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
    #[Route('/sys_settings/{id}', name: 'system', methods: ["GET", "POST", "PUT", "DELETE"])]
    public function system(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $webhook = new Webhook();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $webhook->setUser($user);
        $form = $this->createForm(WebhookType::class, $webhook, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($webhook);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('system',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(Webhook::class);
        $webhooks = $repository->findBy(['user' => $currentUser]);
        return $this->render('settings/system.html.twig', [
            'controller_name' => 'SettingsController',
            'webhooks' => $webhooks,
            'form' => $form->createView(),
        ]);
    }
    // webhook remove
    #[Route('/webhook/delete/{id}', name: 'webhook_delete', methods: ["GET", "POST", "DELETE"])]
    public function webhookDelete(Webhook $webhook, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($webhook);
        $this->entityManager->flush();
        return $this->redirectToRoute('system', ['id' => $id]);
    }
    #[Route('/webhook/{id}/edit/{user_id}', name: 'webhook_edit', methods: ["GET", "POST", "PUT"])]
    public function webhookEdit(Request $request, Webhook $webhooks, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $webhook = new Webhook();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $webhook->setUser($user);
        $form = $this->createForm(WebhookType::class, $webhooks, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->getErrors(true, true));
            $this->entityManager->flush();

            // If the request is AJAX, return a JSON response
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse(['success' => true]);
            }

            return $this->redirectToRoute('system', ['id' => $id]);
        }

        return $this->render('settings/system.html.twig', [
            'form' => $form->createView(),
            'webhooks' => $webhooks,
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
