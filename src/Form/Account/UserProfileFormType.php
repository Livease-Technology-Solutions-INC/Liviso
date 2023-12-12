<?php

namespace App\Form\Account;

use App\Entity\Account\UserProfile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username', // Adjust to the property you want to use as the label
                'label' => 'User',
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('bio',  TextareaType::class, [
                'label' => 'Bio',
                'attr' => [
                    'class' => 'form-control m-0',
                    'rows' => 5,
                    'placeholder' => 'Enter your bio',
                ]
            ])
            ->add('companyName',  TextType::class, [
                'label' => 'Company Name',
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('companyWebsite',  TextType::class, [
                'label' => 'Company Website',
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('facebook',  TextType::class, [
                'label' => 'Facebook',
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('twitter',  TextType::class, [
                'label' => 'Twitter',
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('instagram',  TextType::class, [
                'label' => 'Instagram',
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('linkedin',  TextType::class, [
                'label' => 'LinkedIn',
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('skype',  TextType::class, [
                'label' => 'Skype',
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('github',  TextType::class, [
                'label' => 'Github',
                'attr' => ['class' => 'form-control m-0'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserProfile::class,
        ]);
    }
}
