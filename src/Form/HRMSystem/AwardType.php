<?php

namespace App\Form\HRMSystem;

use App\Entity\HRMSystem\Award;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\AccountingSystem\DataTransformer\UserToIdTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AwardType extends AbstractType
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
            ->add('employee', ChoiceType::class, [
                'label' => 'Employee',
                'choices' => $this->getUserChoices(),
                'attr' => ['class' => 'form-select m-0 text-dark'],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])
            ->add('awardType',  ChoiceType::class, [
                'label' => 'Award Type',
                'choices' => [
                    'Trophy' => 'Trophy',
                    'Gift' => 'Gift',
                    'Medal' => 'Medal'
                ],
                'attr' => ['class' => 'form-select m-0 text-dark'],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])
            ->add('date', DateType::class, [
                'label' => 'Date',
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
            ->add('gift', TextType::class, [
                'label' => 'Gift',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'placeholder' => 'Gift',
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'rows' => 5,
                    'placeholder' => 'Enter your description here...',
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
            'data_class' => Award::class,
            'current_user' => null,
        ]);
    }
}
