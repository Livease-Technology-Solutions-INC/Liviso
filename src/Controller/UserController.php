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
    #[Route('/my_account', name: 'my_account')]
    public function myAccount(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // // Get the currently logged-in user
        // $user = $this->getUser();
        // $someData = [
        //     'email' => $user->getEmail(),
        //     'password' => $user->getPassword(),
        // ];
        // $form = $this->createForm(UserProfileType::class, $user, [
        //     'some_data' => $someData,
        // ]);

        // // Handle form submission
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {

        //     // Persist the User entity (UserProfile will be persisted automatically)
        //     $this->entityManager->persist($user);
        //     $this->entityManager->flush();

        //     // Redirect after successful form submission (optional)
        //     return $this->redirectToRoute('my_account');
        // }

        // Show only the current user's profile
        // $userProfiles = [$user->getProfile()];
        return $this->render('user/myAccount.html.twig', [
            'controller_name' => 'UserController',
            // 'userProfiles' => $userProfiles,
            // 'form' => $form->createView(),
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
