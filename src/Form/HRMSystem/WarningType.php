<?php

namespace App\Form\HRMSystem;

use App\Entity\HRMSystem\Warning;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\AccountingSystem\DataTransformer\UserToIdTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class WarningType extends AbstractType
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
            ->add('warningBy', ChoiceType::class, [
                'label' => 'Warning By',
                'choices' => $this->getUserChoices(),
                'attr' => ['class' => 'form-select m-0 text-dark
                '],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])
            ->add('warningTo',  ChoiceType::class, [
                'label' => 'Warning To',
                'choices' => $this->getUserChoices(),
                'attr' => ['class' => 'form-select m-0 text-dark
                '],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])
            ->add('subject',  TextType::class, [
                'label' => 'Subject',
                'attr' => ['class' => 'form-select m-0 text-dark
                '],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])
            ->add('warningDate', DateType::class, [
                'label' => 'Warning Date',
                'html5' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control m-0 text-dark
                    ',
                    'placeholder' => 'Select Date/Time',
                    'required' => 'required',
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control m-0 text-dark
                    ',
                    'rows' => 5,
                    'placeholder' => 'Enter your description',
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
            'data_class' => Warning::class,
            'current_user' => null,
        ]);
    }
}
