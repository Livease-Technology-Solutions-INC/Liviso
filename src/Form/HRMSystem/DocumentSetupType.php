<?php

namespace App\Form\HRMSystem;

use App\Entity\HRMSystem\Meeting;
use App\Entity\HRMSystem\DocumentSetup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DocumentSetupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Enter Name'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])
            ->add('document', FileType::class, [
                'mapped' => False,
                'attr' => ['class' => 'form-control m-0 text-dark'],
                'label_attr' => [
                    'class' => 'text-dark mt-2',
                ],
            ])
            ->add('role', ChoiceType::class, [
                'label' => 'role',
                'choices' => [
                    'All' => 'All',
                    'Admin' => 'Admin',
                    'Secretary' => 'Secretary',
                    'Accountant' => 'Accountant',
                    'Accounts Manager' => 'Accounts Manager',
                    'Factory Worker' => 'Factory Worker',
                ],
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DocumentSetup::class,
            'current_user' => null,
        ]);
    }
}
