<?php

namespace App\Controller;

use App\Entity\Zoom;
use App\Form\ZoomType;
// use App\Repository\ZoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/', name: 'home', methods: ["GET"])]
    public function index(): RedirectResponse
    {
        return new RedirectResponse($this->generateUrl('account-dashboard'));
    }
    #[Route('/support', name: 'support', methods: ["GET"])]
    public function support(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('main/support.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    // zoom Routes
    #[Route('/zoom', name: 'zoom', methods: ["GET", "POST"])]
    public function zoom(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $zoom = new Zoom();
        $form = $this->createForm(ZoomType::class, $zoom);

        // Handle form submission
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($zoom);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('zoom');
        }

        $repository = $this->entityManager->getRepository(Zoom::class);
        $zooms = $repository->findAll();

        return $this->render('main/zoom.html.twig', [
            'controller_name' => 'MainController',
            'zooms' => $zooms,
            'form' => $form->createView(),
        ]);
    }

    // zoom remove
    #[Route('/zoom/delete/{id}', name: 'zoom_delete', methods: ["GET", "POST"])]
    public function zoomDelete(Zoom $zoom): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($zoom);
        $this->entityManager->flush();
        return $this->redirectToRoute('zoom');
        // return new Response('post was deleted');
    }
    #[Route('/message', name: 'message', methods: ["GET"])]
    public function message(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('main/chat.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
