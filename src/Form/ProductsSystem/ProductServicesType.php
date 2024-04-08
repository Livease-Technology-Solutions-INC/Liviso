<?php

namespace App\Form\ProductsSystem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use App\Entity\ProductsSystem\ProductServices;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use App\Form\AccountingSystem\DataTransformer\UserToIdTransformer;

class ProductServicesType extends AbstractType
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

            ->add('name', TextType::class, [
                'label' => 'Name',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Name'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('sku', TextType::class, [
                'label' => 'Sku',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Sku'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('description', HiddenType::class, [
                'data' => 'product services for products',
            ])

            ->add('salePrice', IntegerType::class, [
                'label' => 'Sale Price',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Sale Price'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            
            ->add('purchaseDate', DateType::class, [
                'label' => 'purchase Date',
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


            ->add('tax', TextType::class, [
                'label' => 'Tax',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Tax'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('category', ChoiceType::class, [
                'label' => 'Category',
                'choices' => [
                    'Electronics' => 'Electronics',
                    'Fashion' => 'Fashion',
                    'Home Accessories' => 'Home Accessories',
                    'Health & Care' => 'Health & Care',
                    'Fruit & vegetables' => 'Fruit & vegetables',
                    'Books' => 'Books',
                ],
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('unit', ChoiceType::class, [
                'label' => 'Unit',
                'choices' => [
                    'Inch' => 'Inch',
                    'Meter' => 'Meter',
                    'Piece' => 'Piece',
                    'Set' => 'Set',
                    'Mass' => 'Mass',
                    'Kg' => 'Kg',
                ],
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('quantity', TextType::class, [
                'label' => 'Quantity',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off',
                    'placeholder' => 'Quantity'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])

            ->add('type', ChoiceType::class, [
                'label' => 'type',
                'choices' => [
                    'Product' => 'Product',
                    'Service' => 'Service',
                ],
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'autocomplete' => 'off'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ])
            
            ->add('productImage', FileType::class, [
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
                'data_class' => ProductServices::class,
                'current_user' => null,
            ]);
        }
    }
