<?php

namespace App\Form\POSSystem;

use App\Entity\POSSystem\Purchase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\Account\DataTransformer\UserToIdTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PurchaseType extends AbstractType
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
            ->add('purchase', TextType::class, [
                'label' => 'Purchase',
                'attr' => [
                    'class' => 'form-control m-0',
                    'placeholder' => 'Enter your purchase',
                ]
            ])
            ->add('vendor',  TextType::class, [
                'label' => 'Vendor',
                'attr' => [
                    'class' => 'form-control m-0',
                    'placeholder' => 'Enter your vendor',
                ],
            ])
            ->add('category',  TextType::class, [
                'label' => 'Category',
                'attr' => [
                    'class' => 'form-control m-0',
                    'placeholder' => 'Enter your category',
                ],
            ])
            ->add('purchaseDate', DateType::class, [
                'label' => 'Purchase Date',
                'html5' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control m-0',
                    'placeholder' => 'Select Date/Time',
                    'required' => 'required',
                ],
            ])
            ->add('status', TextType::class, [
                'label' => 'Status',
                'attr' => [
                    'class' => 'form-control m-0',
                    'placeholder' => 'Enter your status',
                ]
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
            'data_class' => Purchase::class,
            'current_user' => null,
        ]);
    }
}
