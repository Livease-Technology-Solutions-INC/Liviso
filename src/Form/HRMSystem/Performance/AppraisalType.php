<?php

namespace App\Form\HRMSystem\Performance;

use App\Entity\HRMSystem\Performance\Appraisals;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\AccountingSystem\DataTransformer\UserToIdTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class AppraisalType extends AbstractType
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
                    'All Department' => 'All Department',
                    'Financials' => 'Financials',
                    'Industrials' => 'Industrials',
                    'Health Care' => 'Health Care',
                    'Telecommunications' => 'Telecommunications',
                    'Technology' => 'Technology',
                ],
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('designation', TextType::class, [
                'label' => 'Designation',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Enter Designation'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('employee', ChoiceType::class, [
                'label' => 'Employee',
                'choices' => $this->getUserChoices(),
                'attr' => ['class' => 'form-select m-0 text-dark'],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('targetRating', HiddenType::class, [
                'data' => 'Good',
            ])

            ->add('overallRating', HiddenType::class, [
                'data' => 'Good',
            ])

            ->add('appraisalDate', DateType::class, [
                'label' => 'Added Date',
                'data' => new \DateTime(),
                'widget' => 'single_text',
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
            'data_class' => Appraisals::class,
            'current_user' => null,
        ]);
    }
}
