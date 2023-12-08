<?php

namespace App\Form\HRMSystem;

use App\Entity\HRMSystem\CustomQuestions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class CustomQuestionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('question',  TextType::class, [
                'label' => 'Question',
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('isRequired',  ChoiceType::class, [
                'label' => 'is Required',
                'choices' => [
                    'Yes' => 'Yes',
                    'No' => 'No',
                ],
                'attr' => ['class' => 'form-control m-0'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CustomQuestions::class,
        ]);
    }
}
