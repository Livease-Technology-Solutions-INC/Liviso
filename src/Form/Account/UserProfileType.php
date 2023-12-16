<?php

namespace App\Form\Account;

use App\Entity\User;
use App\Entity\Account\UserProfile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\Account\DataTransformer\UserToIdTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserProfileType extends AbstractType
{
    private UserToIdTransformer $userToIdTransformer;

    public function __construct(UserToIdTransformer $userToIdTransformer)
    {
        $this->userToIdTransformer = $userToIdTransformer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // current authicated user
        // $currentUser = $options['current_user'];

        $builder
            ->add('user', HiddenType::class)
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
                'attr' => ['class' => 'form-control m-0'],
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
        $builder->get('user')->addModelTransformer($this->userToIdTransformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserProfile::class,
            'current_user' => null,
        ]);
        $resolver->setAllowedTypes('current_user', [User::class, 'null']);
    }
}
