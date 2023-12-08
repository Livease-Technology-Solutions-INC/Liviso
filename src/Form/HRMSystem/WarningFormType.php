<?php

namespace App\Form\HRMSystem;

use App\Entity\HRMSystem\Warning;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class WarningType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('complaintFrom', ChoiceType::class, [
                'choices' => [
                    'Automatic' => 'Automatic',
                ],
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('complaintAgainst',  ChoiceType::class, [
                'choices' => [
                    'Automatic' => 'Automatic',
                ],
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('complaintTitle',  ChoiceType::class, [
                'choices' => [
                    'Automatic' => 'Automatic',
                ],
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('complaintDate', DateType::class, [
                'label' => 'Meeting Time',
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
                    'placeholder' => 'Enter your description here...',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Warning::class,
        ]);
    }
}
