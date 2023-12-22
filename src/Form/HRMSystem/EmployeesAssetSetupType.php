<?php

namespace App\Form\HRMSystem;

use Symfony\Component\Form\AbstractType;
use App\Entity\HRMSystem\EmployeesAssetSetup;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EmployeesAssetSetupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('employee', ChoiceType::class, [
                'label' => 'Employee',
                'choices' => [
                    'Automatic' => 'Automatic',
                ],
                'attr' => ['class' => 'form-select m-0'],
            ])
            ->add('employeeName',  TextType::class, [
                'label' => 'Name',
                'attr' => ['class' => 'form-control m-0',
                'autocomplete' => 'off'],
            ])
            ->add('amount',  IntegerType::class, [
                'label' => 'Amount',
                'attr' => ['class' => 'form-control m-0'],
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
            ->add('supportedDate', DateType::class, [
                'label' => 'Supported Date',
                'html5' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control m-0',
                    'placeholder' => 'Select Date/Time',
                    'required' => 'required',
                ],
            ])
            ->add('description', TextareaType::class, [
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
            'data_class' => EmployeesAssetSetup::class,
        ]);
    }
}
