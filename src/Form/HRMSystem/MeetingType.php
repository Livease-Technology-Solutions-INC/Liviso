<?php

namespace App\Form\HRMSystem;

use App\Entity\HRMSystem\Meeting;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\AccountingSystem\DataTransformer\UserToIdTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MeetingType extends AbstractType
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
            ->add('branch', ChoiceType::class, [
                'label' => 'Branch',
                'choices' => [
                    'All Branch' => 'All Branch',
                    'China' => 'China',
                    'India' => 'India',
                    'Canada' => 'Canada',
                    'Greece' => 'Greece',
                    'Italy' => 'Italy',
                    'Japan' => 'Japan',
                    'Malaysia' => 'Malaysia',
                    'France' => 'France',
                    'Netherland' => 'Netherland',
                    'Europe' => 'Europe',
                    'USA' => 'USA',
                    'Canada' => 'Canada',
                ],
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])
            ->add('department', ChoiceType::class, [
                'label' => 'Department',
                'choices' => [
                    'All Branch' => 'All Branch',
                    'China' => 'China',
                    'India' => 'India',
                    'Canada' => 'Canada',
                ],
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])
            ->add('employee', ChoiceType::class, [
                'label' => 'Employee Name',
                'choices' => $this->getUserChoices(),
                'attr' => ['class' => 'form-select m-0 text-dark'],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])
            ->add('meetingTitle', TextType::class, [
                'label' => 'Meeting Title',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Enter Meeting Title'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])
            ->add('meetingDate', DateType::class, [
                'label' => 'meeting date',
                'html5' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'placeholder' => 'Select Date/Time',
                    'required' => 'required',
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])
            ->add('meetingTime', TimeType::class, [
                'label' => 'meeting time',
                'html5' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'placeholder' => 'Select Date/Time',
                    'required' => 'required',
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])
            ->add('meetingNote', TextareaType::class, [
                'label' => 'Meeting Note',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Enter Meeting Note'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ]);
    }
    private function getUserChoices()
    {
        $userRepository = $this->entityManager->getRepository('App\Entity\User');
        $users = $userRepository->findAll();

        $choices = [];
        foreach ($users as $user) {
            $choices[$user->getfullName()] = $user;
        }

        return $choices;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Meeting::class,
            'current_user' => null,
        ]);
    }
}
