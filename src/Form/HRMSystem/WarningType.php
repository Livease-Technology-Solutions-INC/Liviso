<?php

namespace App\Form\HRMSystem;

use App\Entity\HRMSystem\Warning;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class WarningType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('warningBy', ChoiceType::class, [
                'label' => 'Warning By',
                'choices' => [
                    'Automatic' => 'Automatic',
                ],
                'attr' => ['class' => 'form-select m-0'],
            ])
            ->add('warningTo',  ChoiceType::class, [
                'label' => 'Warning To',
                'choices' => [
                    'Automatic' => 'Automatic',
                ],
                'attr' => ['class' => 'form-select m-0'],
            ])
            ->add('subject',  TextType::class, [
                'label' => 'Subject',
                'attr' => ['class' => 'form-select m-0'],
            ])
            ->add('warningDate', DateType::class, [
                'label' => 'Warning Date',
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
            'data_class' => Warning::class,
        ]);
    }
}