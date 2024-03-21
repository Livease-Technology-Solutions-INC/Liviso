<?php

namespace App\Form\CRMSystem;

use App\Entity\CRMSystem\FormBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class FormBuilderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('name', TextType::class, [
                'label' => 'Name',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Name'
                ],
            ])

            ->add('response', HiddenType::class, [
                'data' => '0',
            ]);

        }

        public function configureOptions(OptionsResolver $resolver): void
        {
            $resolver->setDefaults([
                'data_class' => FormBuilder::class,
                'current_user' => null,
            ]);
        }
    }
