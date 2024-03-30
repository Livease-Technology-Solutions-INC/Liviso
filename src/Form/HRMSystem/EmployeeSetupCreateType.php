<?php

namespace App\Form\HRMSystem;

use Symfony\Component\Form\AbstractType;
use App\Entity\HRMSystem\EmployeeSetupCreate;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class EmployeesSetupCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',  TextType::class, [
                'label' => 'Name',
                'attr' => ['class' => 'form-control m-0',
                'autocomplete' => 'off'],
            ])

            ->add('phone', TelType::class, [
                'label' => 'Phone',
                'attr' => ['class' => 'form-control m-0',
                'autocomplete' => 'off'],
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                ],
            ])

            ->add('dateOfBirth', BirthdayType::class, [
                'label' => 'Date of Birth',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'constraints' => [
                    new NotBlank(),
                ],
            ])

            ->add('gender', TextType::class, [
                'label' => 'Gender',
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                ],
            ])

            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                    new Email(),
                ],
            ])

            ->add('password', PasswordType::class, [
                'label' => 'Password',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 6]),
                ],
            ])

            ->add('address', TextType::class, [
                'label' => 'Address',
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                ],
            ])

            ->add('branch', TextType::class, [
                'label' => 'Branch',
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                ],
            ])

            ->add('department', TextType::class, [
                'label' => 'Department',
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                ],
            ])

            ->add('designation', TextType::class, [
                'label' => 'Designation',
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                ],
            ])

            ->add('companyDateOfJoining', DateType::class, [
                'label' => 'Purchase Date',
                'html5' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control m-0',
                    'placeholder' => 'Select Date/Time',
                    'required' => 'required',
                ],
            ])

            ->add('certificate', FileType::class, [
                'mapped' => False,
                'attr' => ['class' => 'form-control m-0'],
            ])

            ->add('photo', FileType::class, [
                'mapped' => False,
                'attr' => ['class' => 'form-control m-0'],
            ])

            ->add('accountName', TextType::class, [
                'label' => 'Account Name',
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                    new Regex(['pattern' => '/^\d+$/']),
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
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Account Number'
                ],
            ])

            ->add('bankName', TextType::class, [
                'label' => 'Bank Name',
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                    new Regex(['pattern' => '/^\d+$/']),
                ],
            ])

            ->add('bankIdentifierCode', TextType::class, [
                'label' => 'Bank Identifier Code',
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                    new Regex(['pattern' => '/^\d+$/']),
                ],
            ])

            ->add('branchLocation', TextType::class, [
                'label' => 'Branch Location',
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                    new Regex(['pattern' => '/^\d+$/']),
                ],
            ])

            ->add('taxPayerId', TextType::class, [
                'label' => 'Tax PayerId',
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                    new Regex(['pattern' => '/^\d+$/']),
                ],
            ]);
        }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EmployeeSetupCreate::class,
            'current_user' => null,
        ]);
    }
}
