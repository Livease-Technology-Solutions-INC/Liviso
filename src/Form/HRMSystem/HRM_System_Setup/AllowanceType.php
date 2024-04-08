<?php

namespace App\Form\HRMSystem\HRM_System_Setup;

use App\Entity\HRMSystem\HRM_System_Setup\Allowance;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\AccountingSystem\DataTransformer\UserToIdTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AllowanceType extends AbstractType
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
            ->add('allowance', TextType::class, [
                'label' => 'Allowance',
                'attr' => [
                    'class' => 'form-control m-0 text-dark',
                    'placeholder' => 'Enter Allowance Name'
                ],
                'label_attr' => [
                    'class' => 'text-dark',
                ],
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Allowance::class,
            'current_user' => null,
        ]);
    }
}
