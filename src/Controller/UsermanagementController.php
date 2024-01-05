<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/user/{id}', name: 'user',  methods:["GET", "POST"])]
    public function user(Request $request, int $id, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $existingUser = $this->entityManager->getRepository(User::class)->find($id);
        if (!$existingUser) {
            throw $this->createNotFoundException('The existing user does not exist');
        }
        $newUser = new User();
        $form = $this->createForm(UserType::class, $newUser);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newUser = $form->getData();
            $newUser->setCompanyName($existingUser->getCompanyName());
            $newUser->setParentUser($existingUser);
            // Use the PasswordEncoderInterface to hash the password
            $hashedPassword = $userPasswordHasher->hashPassword($newUser, $newUser->getPassword());
            $newUser->setPassword($hashedPassword);
            $this->entityManager->persist($newUser);
            $this->entityManager->flush();
            return $this->redirectToRoute('user', ['id' => $id]);
        }
        return $this->render('usermanagement/user.html.twig', [
            'controller_name' => 'UsermanagementController',
            'form' => $form->createView(),
        ]);
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
