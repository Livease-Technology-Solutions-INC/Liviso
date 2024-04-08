<?php

namespace App\Form\HRMSystem\HRM_System_Setup;

use App\Entity\HRMSystem\HRM_System_Setup\Department;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\AccountingSystem\DataTransformer\UserToIdTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DepartmentType extends AbstractType
{
    private UserToIdTransformer $userToIdTransformer;
    private EntityManagerInterface $entityManager;

    public function __construct(UserToIdTransformer $userToIdTransformer, EntityManagerInterface $entityManager)
    {
        $this->userToIdTransformer = $userToIdTransformer;
        $this->entityManager = $entityManager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('branch', ChoiceType::class, [
                'label' => 'Branch',
                'choices' => $this->getUserChoices(),
                'attr' => [
                    'class' => 'form-select m-0 text-dark',
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])
            ->add('department', TextType::class, [
                'label' => 'Department',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'placeholder' => 'Enter Department Name'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ]);
    }
    private function getUserChoices()
    {
        $userRepository = $this->entityManager->getRepository('App\Entity\User');
        $users = $userRepository->findAll();

        $choices = [];
        foreach ($users as $user) {
            $branches = $user->getBranch();

            foreach ($branches as $branch) {
                $branchName = $branch->getBranch();

                // Use a unique key based on branch name and user ID
                // $key = $branchName . '_' . $user->getId();
                $key = $branchName;

                // Store the branch name as the choice value and user as the choice label
                $choices[$key] = $branchName;
            }
        }

        return $choices;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Department::class,
            'current_user' => null,
        ]);
    }
}
