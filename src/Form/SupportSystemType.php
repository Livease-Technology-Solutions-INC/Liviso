<?php

namespace App\Form;

use App\Entity\SupportSystem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SupportSystemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject', TextType::class, [
                'attr' => ['class' => 'form-control m-0', 
                'autocomplete' => 'off']
            ])
            ->add('supportForUser',  ChoiceType::class, [
                'label' => 'Support For User',
                'choices' => [
                    'Automatic' => 'Automatic',
                ],
                'attr' => ['class' => 'form-select m-0'],
            ])
            ->add('priority',  ChoiceType::class, [
                'label' => 'Priority',
                'choices' => [
                    'Low' => 'Low',
                    'Medium' => 'Medium',
                    'High' => 'High',
                    'Critical' => 'Critical',
                ],
                'attr' => ['class' => 'form-select m-0'],
            ])
            ->add('status',  ChoiceType::class, [
                'label' => 'Status',
                'choices' => [
                    'Open' => 'Open',
                    'Close' => 'Close',
                    'On Hold' => 'On Hold',
                    'Critical' => 'Critical',
                ],
                'attr' => ['class' => 'form-select m-0'],
            ])
            ->add('endDate', DateType::class, [
                'label' => 'End Date',
                'html5' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control m-0',
                    'placeholder' => 'Select Date',
                    'required' => 'required',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'rows' => 6,
                    'cols' => 32,
                    'class' => 'form-control',
                    'placeholder' => 'Enter your description',
                ]
            ])
            ->add('image', FileType::class, [
                'mapped' => False,
                'attr' => ['class' => 'form-control m-0'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SupportSystem::class,
        ]);
    }
}
