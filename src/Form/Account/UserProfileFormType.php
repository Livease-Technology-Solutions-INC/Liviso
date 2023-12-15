<?php

namespace App\Form\Account;

use App\Entity\Account\UserProfile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // current authicated user
        $currentUser = $options['current_user'];

        $builder
            ->add('user', TextType::class, [
                'data' => $currentUser->getEmail(),
                'disabled' => true,
                'label' => "Email",
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('bio', TextareaType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('mobileNumber', NumberType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('country', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('companyName', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('companyWebsite', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('facebook', TextType::class, [
                'required' => false,
            ])
            ->add('twitter', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('instagram', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('linkedin', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('skype', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('github', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control m-0'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserProfile::class,
            'current_user' => null,
        ]);
    }
}
