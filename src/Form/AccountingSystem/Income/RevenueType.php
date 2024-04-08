<?php

namespace App\Form\AccountingSystem\Income;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use phpDocumentor\Reflection\Types\Integer;
use App\Entity\AccountingSystem\Income\Revenue;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Form\AccountingSystem\DataTransformer\UserToIdTransformer;

class RevenueType extends AbstractType
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


            ->add('amount', IntegerType::class, [
                'label' => 'amount',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'amount'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])


            ->add('account', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^\d{10}$/',
                        'message' => 'The account number should be exactly 10 digits.',
                    ]),
                ],

                'label' => 'Account',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Account'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('customers', TextType::class, [
                'label' => 'Customers',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Customers'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('category', ChoiceType::class, [
                'label' => 'Category',
                'choices' => [
                    'All Category' => 'All Category',
                    'Maintenance Sales' => 'Maintenance Sales',
                    'Product Sales' => 'Product Sales',
                ],
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off'
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
            ])

            ->add('paymentReceipt', FileType::class, [
                'mapped' => False,
                'attr' => ['class' => 'form-control m-0 text-dark'],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Revenue::class,
            'current_user' => null,
        ]);
    }
}
