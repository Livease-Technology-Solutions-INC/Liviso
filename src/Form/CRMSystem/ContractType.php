<?php

namespace App\Form\CRMSystem;

use App\Entity\CRMSystem\Contract;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;;
use App\Form\AccountingSystem\DataTransformer\UserToIdTransformer;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ContractType extends AbstractType
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

            ->add('subject', TextType::class, [
                'label' => 'Subject',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Subject'
                ],
            ])

            ->add('client', ChoiceType::class, [
                'label' => 'Client',
                'choices' => $this->getUserChoices(),
                'attr' => ['class' => 'form-select m-0'],
            ])

            ->add('project', TextType::class, [
                'label' => 'Project',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Project'
                ],
            ])

            ->add('contractType', ChoiceType::class, [
                'label' => 'Contract Type',
                'choices' => [
                    'Marketing' => 'Marketing',
                    'Planning' => 'Planning',
                ],
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off'
                ],
            ])

            ->add('contractValue', IntegerType::class, [
                'label' => 'Contract Value',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Contract Value'
                ],
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
                'label' => 'end Date',
                'html5' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control m-0',
                    'placeholder' => 'Select Date/Time',
                    'required' => 'required',
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
                'data_class' => Contract::class,
                'current_user' => null,
            ]);
        }
    }
