<?php

namespace App\Form\HRMSystem;

use App\Entity\HRMSystem\Trip;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\Account\DataTransformer\UserToIdTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TripType extends AbstractType
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
                'choices' => [
                    'China' => 'China',
                    'India' => 'India',
                ],
                'attr' => ['class' => 'form-select m-0'],
            ])
            ->add('firstName', TextType::class, [
                'label' => 'FirstName',
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'LastName',
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('contact', TextType::class, [
                'label' => 'Contact',
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('expertise', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control m-0',
                    'rows' => 5,
                    'placeholder' => 'Enter your description',
                ]
            ])
            ->add('address', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control m-0',
                    'rows' => 5,
                    'placeholder' => 'Enter your description',
                ]
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trip::class,
            'current_user' => null,
        ]);
    }
}
