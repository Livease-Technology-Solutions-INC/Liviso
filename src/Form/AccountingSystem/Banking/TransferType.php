<?php

namespace App\Form\AccountingSystem\Banking;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\AccountingSystem\Banking\Transfers;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Form\AccountingSystem\DataTransformer\UserToIdTransformer;

class TransferType extends AbstractType
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

            
            ->add('fromAccount', TextType::class, [
                'label' => 'From Account',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'From Account'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('toAccount', TextType::class, [
                'label' => 'To Account',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'To Account'
                ],
            ])

            ->add('amount', IntegerType::class, [
                'label' => 'Amount',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => "$",
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('reference', TextType::class, [
                'label' => 'Reference',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Reference'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'rows' => 5,
                    'placeholder' => 'Description'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ]);
        }

        public function configureOptions(OptionsResolver $resolver): void
        {
            $resolver->setDefaults([
                'data_class' => Transfers::class,
                'current_user' => null,
            ]);
        }
    }
