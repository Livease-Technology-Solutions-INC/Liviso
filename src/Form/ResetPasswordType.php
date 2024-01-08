<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options' => [
                'label' => 'Password',
                'attr' => [
                    'class' => 'form-control m-0',
                    'placeholder' => 'Password',
                    'required' => 'required',
                ],
            ],
            'second_options' => [
                'label' => 'Repeat Password',
                'attr' => [
                    'class' => 'form-control m-0',
                    'placeholder' => 'Repeat Password',
                    'required' => 'required',
                ],
            ],
        ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
