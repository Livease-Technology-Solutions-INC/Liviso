<?php

namespace App\Form\WorkFlowSystem\Sales;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\WorkFlowSystem\Sales\CustomerCreate;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;;
use App\Form\AccountingSystem\DataTransformer\UserToIdTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CustomerCreateType extends AbstractType
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

            ->add('companyName', TextType::class, [
                'label' => 'Comapny Name',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Company Name'
                ],
            ])

            ->add('companyAddress', TextType::class, [
                'label' => 'Comapny Address',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Company Address'
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

            ->add('authorizedPerson', ChoiceType::class, [
                'label' => 'Authorized Person',
                'choices' => $this->getUserChoices(),
                'attr' => ['class' => 'form-select m-0'],
            ])

            ->add('phoneNumber', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^\d{11}$/',
                        'message' => 'The contact number should be exactly 11 digits.',
                    ]),
                ],
                'label' => 'Phone Number',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Phone Number'
                ],
            ])

            ->add('contactEmail', TextType::class, [
                'label' => 'Contact Email',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Contact Email'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                ],
            ])

            ->add('branch1', TextType::class, [
                'label' => 'Branch1',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Branch1'
                ],
            ])

            ->add('branch2', TextType::class, [
                'label' => 'Branch2',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Branch2'
                ],
            ])

            ->add('preferredDeliveryLocation', TextType::class, [
                'label' => 'Preferred Delivery Location',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Preferred Delivery Location'
                ],
            ])

            ->add('contactNumberOfReceiver', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^\d{11}$/',
                        'message' => 'The contact number should be exactly 11 digits.',
                    ]),
                ],

                'label' => 'Contact Number Of Receiver',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Contact Number Of Receiver'
                ],
            ])

            ->add('tradeLicense', FileType::class, [
                'mapped' => False,
                'attr' => ['class' => 'form-control m-0'],
            ])

            ->add('partnerPassportId', FileType::class, [
                'mapped' => False,
                'attr' => ['class' => 'form-control m-0'],
            ])

            ->add('creditTerms', ChoiceType::class, [
                'label' => 'Credit Terms',
                'choices' => [
                    '1 week' => '1 week',
                    '10 days' => '10 days',
                    '30 days' => '30 days',
                    '60 days' => '60 days',
                    '90 days' => '90 days',
                    '120 days' => '120 days',
                ],
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off'
                ],
            ]);
        }

        private function getUserChoices()
    {
        $userRepository = $this->entityManager->getRepository('App\Entity\User');
        $users = $userRepository->findAll();

        $choices = [];
        foreach ($users as $user) {
            $choices[$user->getfullName()] = $user;
        }

        return $choices;
    }

        public function configureOptions(OptionsResolver $resolver): void
        {
            $resolver->setDefaults([
                'data_class' => CustomerCreate::class,
                'current_user' => null,
            ]);
        }
    }