<?php
namespace App\Form;

use App\Dto\EditUserDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Enter FullName',
                'attr' => ['class' => 'form-control m-0 text-dark'],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])
            ->add('userId', HiddenType::class, [
                'label' => 'User ID',
                'attr' => ['readonly' => true],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EditUserDto::class,
        ]);
    }
}
