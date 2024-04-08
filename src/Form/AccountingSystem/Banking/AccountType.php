<?php

namespace App\Form\AccountingSystem\Banking;

use App\Entity\AccountingSystem\Banking\Account;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\AccountingSystem\DataTransformer\UserToIdTransformer;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class AccountType extends AbstractType
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

            ->add('accountName', TextType::class, [
                'label' => 'Account Name',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Account Name'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('bankName', TextType::class, [
                'label' => 'Bank Name',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Bank Name'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('accountNumber', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^\d{10}$/',
                        'message' => 'The account number should be exactly 10 digits.',
                    ]),
                ],

                'label' => 'Account Number',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Account Number'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('currentBalance', NumberType::class, [
                'label' => 'Current Balance',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => "$",
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('contactNumber', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^\d{10}$/',
                        'message' => 'The contact number should be exactly 10 digits.',
                    ]),
                ],

                'label' => 'Contact Number',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Contact Number'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('bankBranch', TextType::class, [
                'label' => 'Bank Branch',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Bank Branch'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Account::class,
            'current_user' => null,
        ]);
    }
}
