<?php

namespace App\Form\HRMSystem;

use App\Entity\HRMSystem\Complaints;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ComplaintsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('complaintFrom', ChoiceType::class, [
                'label' => 'Complaint From',
                'choices' => [
                    'Automatic' => 'Automatic',
                ],
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('complaintAgainst',  ChoiceType::class, [
                'label' => 'Complaint Against',
                'choices' => [
                    'Automatic' => 'Automatic',
                ],
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('complaintTitle',  TextType::class, [
                'label' => 'Complaint Title',
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
            'data_class' => Complaints::class,
        ]);
    }
}
