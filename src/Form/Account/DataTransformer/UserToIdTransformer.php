<?php

namespace App\Form\Account\DataTransformer;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class UserToIdTransformer implements DataTransformerInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function transform($user): ?int
    {
        if (null === $user) {
            return null;
        }

        if (!is_object($user) || !$user instanceof User) {
            throw new TransformationFailedException('Expected an instance of User.');
        }

        return $user->getId();
    }

    public function reverseTransform($userId): ?User
    {
        if (null === $userId) {
            return null;
        }

        $user = $this->entityManager->getRepository(User::class)->find($userId);

        if (null === $user) {
            throw new TransformationFailedException(sprintf('User with ID "%s" not found.', $userId));
        }

        return $user;
    }
}
