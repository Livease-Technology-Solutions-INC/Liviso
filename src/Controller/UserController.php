<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Account\UserProfile;
use App\Form\Account\UserProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/confirmmail', name: 'confirmmail')]
    public function confirmemail(): Response
    {
        return $this->render('user/confirm-mail.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('my_account/{user_id}', name: 'my_account')]
    public function myAccount(Request $request, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // Check if the current user matches the requested user_id
        $currentUser = $this->getUser();

        if ($currentUser === null) {
            return $this->redirectToRoute('app_login');
        }

        // Explicitly assert that $currentUser is not null
        assert($currentUser instanceof User);

        $userId = $currentUser->getId();
        if (!$currentUser instanceof User || $currentUser->getId() !== $user_id) {
            throw $this->createAccessDeniedException('You are not allowed to access this user profile.');
        }

        /** @var User $currentUser */
        $userProfile = $currentUser->getProfile();

        // If the user does not have a profile, create one
        if (!$userProfile) {
            $userProfile = new UserProfile();
            $userProfile->setUser($currentUser);

            $this->entityManager->persist($userProfile);
            $this->entityManager->flush();
        }

        if (!$userProfile) {
            throw $this->createNotFoundException('UserProfile not found for the current user.');
        }

        $email = $currentUser->getEmail();
        $form = $this->createForm(UserProfileType::class, $userProfile, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('my_account', ['user_id' => $user_id]);
        }

        return $this->render('user/myAccount.html.twig', [
            'email' => $email,
            'userProfile' => $userProfile,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/recoverpassword', name: 'recoverpassword')]
    public function recoverpassword(): Response
    {
        return $this->render('user/recoverpw.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
