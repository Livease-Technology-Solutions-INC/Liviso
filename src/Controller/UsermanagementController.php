<?php

namespace App\Controller;

use EditUserType;
use App\Entity\User;
use App\Form\UserType;
use App\Dto\ResetPasswordDto;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UsermanagementController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/user/{id}', name: 'user',  methods: ["GET", "POST"])]
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
            $existingUser->getCompanyName();
            $newUser = $form->getData();
            $newUser->setCompanyName($existingUser->getCompanyName());
            $newUser->setParentUser($existingUser);

            $hashedPassword = $userPasswordHasher->hashPassword($newUser, $newUser->getPassword());
            $newUser->setPassword($hashedPassword);
            $newUser->setEmail($newUser->getEmail());
            $this->entityManager->persist($newUser);
            $this->entityManager->flush();
            return $this->redirectToRoute('user', ['id' => $id]);
        }
        return $this->render('usermanagement/user.html.twig', [
            'controller_name' => 'UsermanagementController',
            'form' => $form->createView(),
        ]);
    }
    #[Route('/user/{id}/reset-password/{child_id}', name: 'reset_password/user', methods: ["POST", "GET"])]
    public function resetPassword(Request $request, int $id, int $child_id, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $existingUser = $this->entityManager->getRepository(User::class)->find($child_id);

        if (!$existingUser) {
            throw $this->createNotFoundException('The existing user does not exist');
        }

        $resetPasswordDto = new ResetPasswordDto();
        $resetPasswordForm = $this->createForm(ResetPasswordType::class, $resetPasswordDto);
        $resetPasswordForm->handleRequest($request);

        if ($resetPasswordForm->isSubmitted() && $resetPasswordForm->isValid()) {
            $newPassword = $resetPasswordDto->getPassword();
            $hashedPassword = $userPasswordHasher->hashPassword($existingUser, $newPassword);
            $existingUser->setPassword($hashedPassword);

            $this->entityManager->flush();

            return $this->redirectToRoute('user', ['id' => $id]);
        }

        return $this->render('usermanagement/edit/resetPasswordUser.html.twig', [
            'controller_name' => 'UsermanagementController',
            'resetPasswordForm' => $resetPasswordForm->createView(),
        ]);
    }
    #[Route('/user/{id}/delete/{child_id}', name: 'delete/user',  methods: ["GET", "POST"])]
    public function deleteUser(int $id, int $child_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->entityManager->getRepository(User::class)->find($child_id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        if ($this->getUser() !== $user->getParentUser()) {
            throw new AccessDeniedException('You do not have permission to delete this user.');
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('user', ['id' => $id]);
    }
    public function editUser(Request $request, int $id, int $user_id, User $user)
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle form submission for editing user
            // ...

            return $this->redirectToRoute('user', ['id' => $id]);
        }

        return $this->render('usermanagement/user.html.twig', [
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
