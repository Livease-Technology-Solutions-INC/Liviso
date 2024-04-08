<?php

namespace App\Form\HRMSystem\HRM_System_Setup;

use App\Entity\HRMSystem\HRM_System_Setup\Document;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\AccountingSystem\DataTransformer\UserToIdTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DocumentType extends AbstractType
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
            ->add('name', TextType::class, [
                'label' => 'Document Type',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'placeholder' => 'Enter Document Name'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])
            ->add('required', ChoiceType::class, [
                "choices" => ['Not Required' => 'Not Required', 
                'is Required' => 'is Required'],
                'label' => 'Days Per Year',
                'attr' => [
                    'class' => 'form-select m-0 text-dark',
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
            $departments = $user->getDepartment();

            foreach ($departments as $department) {
                $departmentName = $department->getDepartment();

                // Use a unique key based on department name and user ID
                // $key = $departmentName . '_' . $user->getId();
                $key = $departmentName;

                // Store the department name as the choice value and user as the choice label
                $choices[$key] = $departmentName;
            }
        }

        return $choices;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Document::class,
            'current_user' => null,
        ]);
    }
}
