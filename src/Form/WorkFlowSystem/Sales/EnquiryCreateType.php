<?php

namespace App\Form\WorkFlowSystem\Sales;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\WorkFlowSystem\Sales\EnquiryCreation;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;;
use App\Form\AccountingSystem\DataTransformer\UserToIdTransformer;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class EnquiryCreateType extends AbstractType
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

            ->add('productCode', ChoiceType::class, [

                'label' => 'Product Code',
                'choices' => [
                    'Auto' => 'Auto',
                ],
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off'
                ],
            ])

            ->add('productQty', IntegerType::class, [
                'label' => 'Product Qty',
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Product Qty'
                ],
            ])

            ->add('requiredDate', ChoiceType::class, [
                'label' => 'Required Date',
                'choices' => [
                    'Auto' => 'Auto',
                ],
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off'
                ],
            ])

            ->add('productCode2', ChoiceType::class, [
                'label' => 'Product Code2',
                'choices' => [
                    'Confirmed' => 'Confirmed',
                    'Guaranteed Sale' => 'Guaranteed Sale',
                    'Forecast' => 'Forecast',
                ],
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off'
                ],
            ])

            ->add('orderBy', ChoiceType::class, [
                'label' => 'Order By',
                'choices' => [
                    'Auto' => 'Auto',
                ],
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off'
                ],
            ])

            ->add('orderUnder', ChoiceType::class, [
                'label' => 'Order Under',
                'choices' => [
                    'Auto' => 'Auto',
                ],
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off'
                ],
            ])

            ->add('orderFor', ChoiceType::class, [
                'label' => 'Order For',
                'choices' => $this->getUserChoices(),
                'attr' => ['class' => 'form-select m-0'],
            ])

            ->add('requiredPrice', NumberType::class, [
                'attr' => [
                    'class' => 'form-control m-0',
                    'autocomplete' => 'off',
                    'placeholder' => 'Required Price'
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
            'data_class' => EnquiryCreation::class,
            'current_user' => null,
        ]);
    }
}