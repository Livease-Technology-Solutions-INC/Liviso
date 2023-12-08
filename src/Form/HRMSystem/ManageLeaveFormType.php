<?php

namespace App\Form;

use App\Entity\HRMSystem\ManageLeave;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ManageLeaveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
                'attr' => ['class' => 'form-control m-0'],
            ])
            ->add('startTime', DateTimeType::class, [
                'label' => 'Start Date',
                'html5' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control m-0',
                    'required' => 'required',
                ],
            ])
            ->add('endTime', DateTimeType::class, [
                'label' => 'Start Date',
                'html5' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control m-0',
                    'required' => 'required',
                ],
            ])
            ->add('leaveReason', TextType::class, [
                'label' => 'Meeting URL',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ManageLeave::class,
        ]);
    }
}
