<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UsermanagementController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/user/{id}', name: 'user')]
    public function user(int $id, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $existingUser = $this->entityManager->getRepository(User::class)->find($id);
        if (!$existingUser) {
            throw $this->createNotFoundException('The existing user does not exist');
        }
        $newUser = new User();
        $newUser->setFullName("Danny funds");
        $newUser->setEmail('sample@example.com');
        $hashedPassword = $userPasswordHasher->hashPassword($newUser, 'password123');
        $newUser->setPassword($hashedPassword);
        $existingUser->addLinkedUser($newUser);
        $this->entityManager->persist($newUser);
        $this->entityManager->flush();


        $this->addFlash('success', 'New user created and linked successfully.');
        return $this->redirectToRoute('client');
        // return $this->render('usermanagement/user.html.twig', [
        //     'controller_name' => 'UsermanagementController',
        // ]);
    }
    #[Route('/role', name: 'role')]
    public function role(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('usermanagement/role.html.twig', [
            'controller_name' => 'UsermanagementController',
        ]);
    }
    #[Route('/client', name: 'client')]
    public function client(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('usermanagement/client.html.twig', [
            'controller_name' => 'UsermanagementController',
        ]);
    }
}
