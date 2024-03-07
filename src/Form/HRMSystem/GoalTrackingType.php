<?php

namespace App\Form\HRMSystem;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\HRMSystem\Performance\GoalTrackings;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\Account\DataTransformer\UserToIdTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class GoalTrackingType extends AbstractType
{
    private UserToIdTransformer $userToIdTransformer;
    private EntityManagerInterface $entityManager;

    public function __construct(UserToIdTransformer $userToIdTransformer, EntityManagerInterface $entityManager)
    {
        $this->userToIdTransformer = $userToIdTransformer;
        $this->entityManager = $entityManager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('branch', TextType::class, [
                'label' => 'Branch',
                'attr' => ['class' => 'form-select m-0'],
            ])
            ->add('goalType', ChoiceType::class, [
                'label' => 'Goal Type',
                'choices' => [
                    'Long Term Goal' => 'Long Term Goal',
                    'Short Term Goal' => 'Long Term Goal',
                ],
                'attr' => ['class' => 'form-select m-0'],
            ])
            ->add('startDate', DateType::class, [
                'label' => 'Start Date',
                'html5' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control m-0',
                    'placeholder' => 'Select Date/Time',
                    'required' => 'required',
                ],
            ])
            ->add('endDate', DateType::class, [
                'label' => 'End Date',
                'html5' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control m-0',
                    'placeholder' => 'Select Date/Time',
                    'required' => 'required',
                ],
            ])
            ->add('subject',  TextType::class, [
                'label' => 'Subject',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off'
                ],
            ])
            ->add('targetAchievement',  TextType::class, [
                'label' => 'Target Acheivement',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off'
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control m-0',
                    'rows' => 5,
                    'placeholder' => 'Enter your description',
                ]
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Status',
                'choices' => [
                    'Not Started' => 'Not Started',
                    'In progress' => 'In progress',
                    'Completed' => 'Completed',
                ],
                'attr' => [
                    'class' => 'form-select m-0',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GoalTrackings::class,
            'current_user' => null,
        ]);
    }
}
