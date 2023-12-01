<?php

namespace App\Controller;

use App\Entity\Zoom;
use App\Repository\ZoomRepository;
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
    #[Route('/zoom', name: 'zoom', methods: ["GET"])]
    public function zoom(ZoomRepository $zoomRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $zoom = $zoomRepository->findAll();
        // dd($zoom);
        return $this->render('main/zoom.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/zoom/create', name: 'zoom_create', methods: ["GET", "POST"])]
    public function zoomCreate(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $zoom = new Zoom();
        $zoom->setTitle('cand');
        $zoom->setProject('mandy');
        $zoom->setUser('william');
        $meetingTime = new \DateTime('2023-11-22 07:10:00');
        $zoom->setMeetingTime($meetingTime);
        $zoom->setDuration(20);
        $this->entityManager->persist($zoom);
        $this->entityManager->flush();
        // Redirect back to the '/zoom' page
        // return $this->redirectToRoute('zoom');
        return new Response('post was created');
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
