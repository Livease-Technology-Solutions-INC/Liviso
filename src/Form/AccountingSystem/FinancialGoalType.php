<?php

namespace App\Form\AccountingSystem;

use App\Entity\AccountingSystem\FinancialGoal;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class FinancialGoalType extends AbstractType
{
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

            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    'All Type' => 'All Type',
                    'Invoice' => 'Invoice',
                    'Bill' => 'Bill',
                    'Revenue' => 'Revenue',
                    'Payment' => 'Payment',
                ],
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])
            
            ->add('fromDate', DateType::class, [
                'label' => 'From Date',
                'html5' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'placeholder' => 'Select Date/Time',
                    'required' => 'required',
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('toDate', DateType::class, [
                'label' => 'To Date',
                'html5' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'placeholder' => 'Select Date/Time',
                    'required' => 'required',
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            
            ->add('amount', IntegerType::class, [
                'label' => 'amount',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => "$",
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])


            ->add('isDashboardDisplay', CheckboxType::class, [
                'label' => 'IsDashboardDisplay',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input',
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ]);

        }

        public function configureOptions(OptionsResolver $resolver): void
        {
            $resolver->setDefaults([
                'data_class' => FinancialGoal::class,
                'current_user' => null,
            ]);
        }
    }
