<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserImageType;
use App\Entity\Account\UserImage;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserImageController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/upload_image/{id}', name: 'upload_image')]
    public function uploadImage(Request $request, int $id): Response
    {
        // Retrieve the current user
        $user = $this->getUser();

        // Ensure the user is authenticated
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('User not authenticated.');
        }

        // Create a new UserImage entity and set the user
        $userImage = new UserImage();
        $userImage->setUser($user);

        // Create a form for uploading the image
        $form = $this->createForm(UserImageType::class, $userImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            // $file = $request->files->get('fileInput');
            $imageFile = $form->get('imagePath')->getData();
            if ($imageFile) {
                // Generate a unique filename and move the file to the desired directory
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('profileImage_dir'),
                    $newFilename
                );

                // Set the image URL in the UserImage entity
                $userImage->setImageUrl($newFilename);
            }

            // Get the entity manager and persist the UserImage entity
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($userImage);
            $entityManager->flush();

            // Redirect to some page (e.g., user's profile) after successful upload
            return $this->redirectToRoute('my_account', ['user_id' => $id]);
        }
        return $this->render('user_image/upload.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}