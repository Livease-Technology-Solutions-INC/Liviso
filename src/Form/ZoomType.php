<?php

namespace App\Form;

use App\Entity\Zoom;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ZoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('project')
            ->add('user')
            ->add('meetingTime')
            ->add('duration')
            ->add('meetingURL')
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Option 1' => 'Soon',
                    'Option 2' => 'Live',
                    'Option 3' => 'Ended',
                    // Add more options as needed
                ],
                'attr' => ['class' => 'form-control m-0'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Zoom::class,
        ]);
    }
}
