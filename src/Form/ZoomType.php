<?php

namespace App\Form;

use App\Entity\Zoom;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ZoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('project',  ChoiceType::class, [
                'choices' => [
                    'Automatic' => 'Automatic',
                ],
                'attr' => ['class' => 'form-select m-0'],
            ])
            ->add('user',  ChoiceType::class, [
                'choices' => [
                    'Automatic' => 'Automatic',
                ],
                'attr' => ['class' => 'form-select m-0'],
            ])
            ->add('meetingTime', DateTimeType::class, [
                'label' => 'Meeting Time',
                'html5' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control m-0',
                    'placeholder' => 'Select Date/Time',
                    'required' => 'required',
                ],
            ])
            ->add('duration')
            ->add('meetingURL', TextType::class, [
                'label' => 'Meeting URL',
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Soon' => 'Soon',
                    'Live' => 'Live',
                    'Ended' => 'Ended',
                ],
                'attr' => ['class' => 'form-select m-0'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Zoom::class,
        ]);
    }
}
