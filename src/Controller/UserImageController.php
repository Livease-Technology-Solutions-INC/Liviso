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
        // Check if the request has files
        if ($request->files->count() > 0) {
            $imageFile = $request->files->get('fileInput');

            // Generate a unique filename
            $newFilename = uniqid() . '.' . $imageFile->guessExtension();

            // Move the file to the desired directory
            $imageFile->move(
                $this->getParameter('profileImage_dir'),
                $newFilename
            );

            // Create a new UserImage entity and set the user and image URL
            $userImage = new UserImage();
            $userImage->setUser($user);
            $userImage->setImageUrl($newFilename);

            // Get the entity manager and persist the UserImage entity
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($userImage);
            $entityManager->flush();

            // Redirect to some page (e.g., user's profile) after successful upload
            return $this->redirectToRoute('my_account', ['user_id' => $id]);
        }
    }
}
