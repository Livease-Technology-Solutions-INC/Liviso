<?php

namespace App\Form\AccountingSystem\Expense;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use phpDocumentor\Reflection\Types\Integer;
use App\Entity\AccountingSystem\Expense\Payment;
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

class PaymentType extends AbstractType
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
                    'class' => 'form-control m-0',
                    'placeholder' => 'Select Date/Time',
                    'required' => 'required',
                ],
            ])

            
            ->add('amount', IntegerType::class, [
                'label' => 'amount',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'amount'
                ],
            ])


            ->add('account', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^\d{10}$/',
                        'message' => 'The contact number should be exactly 10 digits.',
                    ]),
                ],

                'label' => 'Account',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Account'
                ],
            ])

            ->add('vendor', TextType::class, [
                'label' => 'Vendor',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Vendor'
                ],
            ])

            ->add('category', ChoiceType::class, [
                'label' => 'Category',
                'choices' => [
                    'All Category' => 'All Category',
                    'Rent' => 'Rent',
                    'Travel' => 'Travel',
                ],
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off'
                ],
            ])

            ->add('reference', TextType::class, [
                'label' => 'Reference',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Reference'
                ],
            ])

            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'rows' => 5,
                    'placeholder' => 'Description'
                ],
            ])
            
            ->add('paymentReceipt', FileType::class, [
                'mapped' => False,
                'attr' => ['class' => 'form-control m-0'],
            ]);
        }

        public function configureOptions(OptionsResolver $resolver): void
        {
            $resolver->setDefaults([
                'data_class' => Payment::class,
                'current_user' => null,
            ]);
        }
    }
