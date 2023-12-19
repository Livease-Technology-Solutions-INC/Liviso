<?php

namespace App\Form\HRMSystem;

use App\Entity\HRMSystem\ManageLeave;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ManageLeaveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('employee',  ChoiceType::class, [
                'choices' => [
                    'Automatic' => 'Automatic',
                ],
                'attr' => ['class' => 'form-select m-0'],
            ])
            ->add('leaveType',  ChoiceType::class, [
                'choices' => [
                    'Bereavement Leave' => 'Bereavement Leave',
                    'Paternity Leave' => 'Paternity Leave',
                    'Annual Leave' => 'Bereavement Leave',
                    'Bereavement Leave' => 'Annual Leave',
                    'Maternity Leave' => 'Maternity Leave',
                    'Unpaid Leave' => 'Unpaid Leave',
                    'Compensatory Leave' => 'Compensatory Leave',
                    'Study Leave' => 'Study Leave',
                    'Sabbatical Leave' => 'Sabbatical Leave',
                    'Holidays' => 'Holidays',
                ],
                'attr' => ['class' => 'form-select m-0'],
            ])
            ->add('startDate', DateType::class, [
                'label' => 'Start Date',
                'html5' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control m-0',
                    'required' => 'required',
                ],
            ])
            ->add('endDate', DateType::class, [
                'label' => 'Start Date',
                'html5' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control m-0',
                    'required' => 'required',
                ],
            ])
            ->add('leaveReason', TextareaType::class, [
                'label' => 'Leave Reason',
                'attr' => [
                    'class' => 'form-control m-0',
                    'rows' => 5,
                    'placeholder' => 'Enter your description',
                ]
            ])
            ->add('remark', TextareaType::class, [
                'label' => 'Remark',
                'attr' => [
                    'class' => 'form-control m-0',
                    'rows' => 5,
                    'placeholder' => 'Enter your description',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ManageLeave::class,
        ]);
    }
}
