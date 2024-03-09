<?php
namespace App\Form;

use App\Entity\User;
use App\Entity\AccountingSystem\UserImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imagePath', FileType::class, [
                'label' => 'Profile Image',
                'mapped' => false,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserImage::class,
            'current_user' => null,
        ]);
        $resolver->setAllowedTypes('current_user', [User::class, 'null']);
    }
}