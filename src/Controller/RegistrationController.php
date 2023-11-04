<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->isCsrfTokenValid('form_token_id', $request->request->get('_token'))) {
                // Your form processing logic
            } else {
                // Handle invalid CSRF token
            }
            // Get the submitted full name from the form
            $fullName = $form->get('fullName')->getData();

            // Set the full name for the user
            $user->setFullName($fullName);

            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $userRepository = $entityManager->getRepository(User::class);
            $userFromDB = $userRepository->findOneBy(['email' => $user->getEmail()]);

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            $session->set('fullName', $fullName);
            return $this->redirectToRoute('account-dashboard');
        }
        // Pass the user's full name to the template
        // Fetch user data from the database based on the email
        // $userFromDB = $entityManager->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);

        // $fullName = $userFromDB ? $userFromDB->getFullName() : null;


        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            // 'fullName' => $fullName,
        ]);
    }
}
