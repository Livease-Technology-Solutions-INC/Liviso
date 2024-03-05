<?php

namespace App\Form\HRMSystem\Performance;

use App\Entity\HRMSystem\Performance\Indicator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\Account\DataTransformer\UserToIdTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class IndicatorType extends AbstractType
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
        $userRepository = $this->entityManager->getRepository('App\Entity\User');
        $users = $userRepository->findAll();

        $choices = [];
        foreach ($users as $user) {
            
            $choices[$user->getFullName()] = $user;
        }
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
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off'
                ],
            ])
            ->add('department', ChoiceType::class, [
                'label' => 'Department',
                'choices' => [
                    'All Department' => 'All Department',
                    'Financials' => 'Financials',
                    'Industrials' => 'Industrials',
                    'Health Care' => 'Health Care',
                    'Telecommunications' => 'Telecommunications',
                    'Technology' => 'Technology',
                ],
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off'
                ],
            ])

            ->add('designation', TextType::class, [
                'label' => 'Designation',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Enter Designation'
                ],
            ])

            ->add('overallRating', HiddenType::class, [
                'data' => 'Good',
            ])

            ->add('addedBy', DateType::class, [
                'label' => 'Added Date',
                'data' => new \DateTime(),
                'widget' => 'single_text',
            ])
            
            ->add('createdBy', HiddenType::class, [
                'data' => $choices ? reset($choices) : null,
            ]);
        }
        public function configureOptions(OptionsResolver $resolver): void
        {
            $resolver->setDefaults([
                'data_class' => Indicator::class,
                'current_user' => null,
            ]);
        }
    }
