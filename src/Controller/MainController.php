<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Zoom;
use App\Form\ZoomType;
use App\Entity\SupportSystem;
use App\Form\SupportSystemType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\User\UserInterface;
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
    #[Route('/support', name: 'support', methods: ["GET", 'POST', "PUT"])]
    public function support(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $support = new SupportSystem();
        $form = $this->createForm(SupportSystemType::class, $support);

        // Handle form submission
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $request->files->get(key: 'support_system')['image'];
            if ($file) {
                $fileName = md5(uniqid()) . '.' . $file->guessClientExtension();
                try {
                    $file->move($this->getParameter(name: 'support_dir'));
                    $fileName;
                } catch (\Exception $e) {
                    $this->addFlash('error', 'There was an issue with the image');
                    return $this->redirectToRoute('support');
                }
                $support->setImage($fileName);
            }
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($support);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('support');
        }

        $repository = $this->entityManager->getRepository(SupportSystem::class);
        $supports = $repository->findAll();

        return $this->render('main/support.html.twig', [
            'controller_name' => 'MainController',
            'supports' => $supports,
            'form' => $form->createView(),
        ]);
    }
    // support delete
    #[Route('/support/delete/{id}', name: 'support_delete', methods: ["GET", "POST"])]
    public function supportDelete(SupportSystem $support): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($support);
        $this->entityManager->flush();
        return $this->redirectToRoute('support');
    }
    // support edit
    #[Route("/support/{id}/edit", name: "support_edit", methods: ["GET", "PUT", "POST"])]
    public function supportEdit(Request $request, int $id): Response
    {
        $repository = $this->entityManager->getRepository(SupportSystem::class);
        $support = $repository->find($id);

        if (!$support) {
            throw $this->createNotFoundException('support not found');
        }
        $form = $this->createForm(SupportSystemType::class, $support);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $support = $form->getData();
                $this->entityManager->persist($support);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('support');
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(SupportSystem::class);
        $supports = $repository->findAll();

        return $this->render('main/edit/support.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView(),
            'supports' => $supports,
        ]);
    }
    // zoom Routes
    #[Route('/zoom/{id}', name: 'zoom', methods: ["GET", "POST"])]
    public function zoom(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // check
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $zoom = new Zoom();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $zoom->setUser($user);
        $form = $this->createForm(ZoomType::class, $zoom, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($zoom);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('zoom', ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(Zoom::class);
        $zooms = $repository->findBy(['user' => $currentUser]);

        return $this->render('main/zoom.html.twig', [
            'controller_name' => 'MainController',
            'zooms' => $zooms,
            'form' => $form->createView(),
        ]);
    }
    // zoom delete
    #[Route('/zoom/delete/{id}', name: 'zoom_delete', methods: ["GET", "POST"])]
    public function zoomDelete(Zoom $zoom, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($zoom);
        $this->entityManager->flush();
        return $this->redirectToRoute('zoom', ['id' => $id]);
    }
    // edit zoom
    #[Route("/zoom/{id}/edit/{user_id}", name: "zoom_edit", methods: ["GET", "PUT", "POST"])]
    public function zoomEdit(Request $request, int $id, int $user_id): Response
    {
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(Zoom::class);
        $zoom = $repository->find($id);

        if (!$zoom) {
            throw $this->createNotFoundException('zoom not found');
        }

        $form = $this->createForm(ZoomType::class, $zoom, ['current_user' => $this->getUser()]);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $zoom = $form->getData();
                $this->entityManager->persist($zoom);
                $this->entityManager->flush();

                return $this->redirectToRoute('zoom', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(Zoom::class);
        $zooms = $repository->findBy(['user' => $currentUser]);

        return $this->render('main/edit/zoom.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView(),
            'zooms' => $zooms,
        ]);
    }

    #[Route('/message', name: 'message', methods: ["GET", "POST"])]
    public function message(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('main/chat.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
