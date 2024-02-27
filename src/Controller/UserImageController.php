<?php

namespace App\Controller;

use App\Form\UserImageType;
use App\Entity\Account\UserImage;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UserImageController extends AbstractController
{
    private $doctrine;
    private $security;

    public function __construct(ManagerRegistry $doctrine, Security $security)
    {
        $this->doctrine = $doctrine;
        $this->security = $security;
    }

    #[Route('/uploadImage', name: 'upload_image')]
    public function uploadImage(Request $request): Response
    {
        $userImage = new UserImage();
        
        // Get the current user
        $user = $this->security->getUser();
        
        // Set the user for the user image
        $userImage->setUser($user);
        
        $userImage = new UserImage();
        $form = $this->createForm(UserImageType::class, $userImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            $imageFile = $form->get('imagePath')->getData();
            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                // Move the file to the directory where images are stored
                $imageFile->move(
                    $this->getParameter('profileImage_dir'),
                    $newFilename
                );

                $userImage->setImageUrl($newFilename);
            }

            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($userImage);
            $entityManager->flush();

            //return $this->redirectToRoute('my_account/{user_id}');
        }

        return $this->render('userImage/userImage.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}