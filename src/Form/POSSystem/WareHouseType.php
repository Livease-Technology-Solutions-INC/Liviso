<?php

namespace App\Form\POSSystem;

use App\Entity\POSSystem\WareHouse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\AccountingSystem\DataTransformer\UserToIdTransformer;

class WareHouseType extends AbstractType
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
                'label' => 'Name',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'placeholder' => 'Enter your name',
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])
            ->add('address',  TextType::class, [
                'label' => 'Address',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'placeholder' => 'Enter your address',
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])
            ->add('city',  TextType::class, [
                'label' => 'City',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'placeholder' => 'Enter your city',
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])
            ->add('zipCode',  TextType::class, [
                'label' => 'Zip Code',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'placeholder' => 'Enter your zipcode',
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])
            ->add('status', TextType::class, [
                'label' => 'Status',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'placeholder' => 'Enter your status',
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ]);
    }
    // private function getUserChoices()
    // {
    //     $userRepository = $this->entityManager->getRepository('App\Entity\User');
    //     $users = $userRepository->findAll();

    //     $choices = [];
    //     foreach ($users as $user) {
    //         $choices[$user->getfullName()] = $user;
    //     }

    //     return $choices;
    // }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WareHouse::class,
            'current_user' => null,
        ]);
    }
}
