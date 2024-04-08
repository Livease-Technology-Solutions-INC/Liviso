<?php

namespace App\Form\AccountingSystem;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use App\Entity\AccountingSystem\Customer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\AccountingSystem\DataTransformer\UserToIdTransformer;

class CustomerType extends AbstractType
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
                    'autocomplete' => 'off',
                    'placeholder' => 'Name'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('contact', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^\d{10}$/',
                        'message' => 'The contact number should be exactly 10 digits.',
                    ]),
                ],

                'label' => 'Contact',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Contact'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('email', TextType::class, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Email'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('taxNumber', TextType::class, [
                'label' => 'Tax Number',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Tax Number'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('billingName', TextType::class, [
                'label' => 'Billing Name',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Billing Name'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('phone', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^\d{10}$/',
                        'message' => 'The contact number should be exactly 10 digits.',
                    ]),
                ],

                'label' => 'Phone',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Phone'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('address', TextType::class, [
                'label' => 'Address',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Address'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('city', TextType::class, [
                'label' => 'City',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'City'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('state', TextType::class, [
                'label' => 'State',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'State'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('country', TextType::class, [
                'label' => 'Country',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Country'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('zipCode', TextType::class, [
                'label' => 'Zip Code',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Zip Code'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('shippingName', TextType::class, [
                'label' => 'Shipping Name',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Shipping Name'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('phoneNumber', TextType::class, [
                'label' => 'Tax Number',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Tax Number'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('shippingAddress', TextType::class, [
                'label' => 'Shipping Address',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Shipping Address'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('shippingCity', TextType::class, [
                'label' => 'Shipping City',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Shipping City'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])


            ->add('shippingState', TextType::class, [
                'label' => 'Shipping State',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Shipping State'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('shippingCountry', TextType::class, [
                'label' => 'Shipping Country',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Shipping Country'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('shippingZipcode', TextType::class, [
                'label' => 'Shipping Zip Code',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Shipping Zip Code'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
            'current_user' => null,
        ]);
    }
}
