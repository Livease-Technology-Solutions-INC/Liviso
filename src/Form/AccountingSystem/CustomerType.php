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
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Name'
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
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Contact'
                ],
            ])

            ->add('email', TextType::class, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Email'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                ],
            ])

            ->add('taxNumber', TextType::class, [
                'label' => 'Tax Number',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Tax Number'
                ],
            ])

            ->add('billingName', TextType::class, [
                'label' => 'Billing Name',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Billing Name'
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
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Phone'
                ],
            ])

            ->add('address', TextType::class, [
                'label' => 'Address',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Address'
                ],
            ])

            ->add('city', TextType::class, [
                'label' => 'City',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'City'
                ],
            ])

            ->add('state', TextType::class, [
                'label' => 'State',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'State'
                ],
            ])

            ->add('country', TextType::class, [
                'label' => 'Country',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Country'
                ],
            ])

            ->add('zipCode', TextType::class, [
                'label' => 'Zip Code',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Zip Code'
                ],
            ])

            ->add('shippingName', TextType::class, [
                'label' => 'Shipping Name',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Shipping Name'
                ],
            ])

            ->add('phoneNumber', TextType::class, [
                'label' => 'Tax Number',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Tax Number'
                ],
            ])

            ->add('shippingAddress', TextType::class, [
                'label' => 'Shipping Address',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Shipping Address'
                ],
            ])

            ->add('shippingCity', TextType::class, [
                'label' => 'Shipping City',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Shipping City'
                ],
            ])


            ->add('shippingState', TextType::class, [
                'label' => 'Shipping State',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Shipping State'
                ],
            ])

            ->add('shippingCountry', TextType::class, [
                'label' => 'Shipping Country',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Shipping Country'
                ],
            ])

            ->add('shippingZipcode', TextType::class, [
                'label' => 'Shipping Zip Code',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Shipping Zip Code'
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
