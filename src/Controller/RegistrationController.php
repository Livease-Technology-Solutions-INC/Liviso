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
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;


class RegistrationController extends AbstractController
{
    private $geoIpReader;

    public function __construct(Reader $geoIpReader)
    {
        $this->geoIpReader = $geoIpReader;
    }

    #[Route('/register', name: 'register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $user = new User();

        $ipAddress = $request->getClientIp();
        $countryName = '';
         // Use GeoIP2 to get the user's country
         try {
            $record = $this->geoIpReader->country($ipAddress);
            $countryName = $record->country->name;

        } catch (AddressNotFoundException $e) {
           
        } catch (\Exception $e) {
        }
        $user->setLocation($countryName);

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->isCsrfTokenValid('form_token_id', $request->request->get('_token'))) {
                // Your form processing logic
            } else {
                // Handle invalid CSRF token
            }
            $formData = $form->getData();
            // Get the submitted full name from the form
            $fullName = $form->get('fullName')->getData();

            // Set the full name for the user
            $user->setFullName($fullName);


            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->get('first')->getData()
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


        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
