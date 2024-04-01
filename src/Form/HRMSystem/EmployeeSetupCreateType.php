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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                'autocomplete' => 'off', 
                'placeholder' => 'Enter Name'],
            ])

            ->add('phone', TelType::class, [
                'label' => 'Phone',
                'attr' => ['class' => 'form-control m-0',
                'autocomplete' => 'off', 
                'placeholder' => 'Enter Phone'],
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                ],
            ])

            ->add('dateOfBirth', BirthdayType::class, [
                'label' => 'Date of Birth',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'form-control m-0',
                'autocomplete' => 'off'],
                'constraints' => [
                    new NotBlank(),
                ],
            ])

            ->add('gender', ChoiceType::class, [
                'label' => 'Gender',
                'choices' => [
                    'Male' => 'male',
                    'Female' => 'female',
                ],
                'expanded' => true,
                'multiple' => false,
                'choice_attr' => function($choice, $key, $value) {
                    return ['class' => 'btn btn-outline-primary'];
                },
            ])

            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['class' => 'form-control m-0',
                'autocomplete' => 'off', 
                'placeholder' => 'Enter Email'],
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                    new Email(),
                ],
            ])

            ->add('password', PasswordType::class, [
                'label' => 'Password',
                'attr' => ['class' => 'form-control m-0',
                'autocomplete' => 'off'],
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 6]),
                ],
            ])

            ->add('address', TextType::class, [
                'label' => 'Address',
                'attr' => ['class' => 'form-control m-0',
                'autocomplete' => 'off', 
                'placeholder' => 'Enter Address'],
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                ],
            ])

            ->add('branch', ChoiceType::class, [
                'label' => 'Branch',
                'choices' => [
                    'All Branch' => 'All Branch',
                    'China' => 'China',
                    'India' => 'India',
                    'Canada' => 'Canada',
                    'Greece' => 'Greece',
                    'Italy' => 'Italy',
                    'Japan' => 'Japan',
                    'Malaysia' => 'Malaysia',
                    'France' => 'France',
                    'Netherland' => 'Netherland',
                    'Europe' => 'Europe',
                    'USA' => 'USA',
                    'Canada' => 'Canada',
                ],
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off'
                ],
            ])

            ->add('department', ChoiceType::class, [
                'label' => 'Department',
                'choices' => [
                    'All Department' => 'All Department',
                    'Dept 1' => 'Dept 1',
                    'Financials' => 'Financials',
                    'Industrials' => 'Industrials',
                    'Health Care' => 'Health Care',
                    'Technology' => 'Technology',
                    'Telecommunications' => 'Telecommunications',
                ],
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off'
                ],
            ])

            ->add('designation', ChoiceType::class, [
                'label' => 'Designation',
                'choices' => [
                    'All Designation' => 'All Designation',
                    'CEO' => 'CEO',
                    'Charted' => 'Charted',
                    'Developers' => 'Developers',
                    'Manager' => 'Manager',
                ],
                'attr' => ['class' => 'form-control m-0',
                'autocomplete' => 'off'],
            ])

            ->add('companyDateOfJoining', DateType::class, [
                'label' => 'Company Date Of Joining',
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
                'attr' => ['class' => 'form-control m-0',
                'autocomplete' => 'off', 
                'placeholder' => 'Enter Account Name'],
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
                    'placeholder' => 'Enter Account Number'
                ],
            ])

            ->add('bankName', TextType::class, [
                'label' => 'Bank Name',
                'attr' => ['class' => 'form-control m-0',
                'autocomplete' => 'off', 
                'placeholder' => 'Enter Bank Name'],
            ])

            ->add('bankIdentifierCode', TextType::class, [
                'label' => 'Bank Identifier Code',
                'attr' => ['class' => 'form-control m-0',
                'autocomplete' => 'off', 
                'placeholder' => 'Enter BankIdentifierCode'],
            ])

            ->add('branchLocation', TextType::class, [
                'label' => 'Branch Location',
                'attr' => ['class' => 'form-control m-0',
                'autocomplete' => 'off', 
                'placeholder' => 'Enter branchLocation'],
                
            ])

            ->add('taxPayerId', TextType::class, [
                'label' => 'Tax PayerId',
                'attr' => ['class' => 'form-control m-0',
                'autocomplete' => 'off', 
                'placeholder' => 'Enter taxPayerId'],
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
