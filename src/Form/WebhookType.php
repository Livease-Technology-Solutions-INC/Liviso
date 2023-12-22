<?php

namespace App\Form;

use App\Entity\Webhook;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class WebhookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('module', ChoiceType::class, [
                'choices' => [
                    'New Lead' => 'New Lead',
                    "Lead to deal conversion" => "Lead to deal conversion",
                    "New project" => "New roject",
                    "Task stage updated" => "Task stage updated",
                    "New deal" => "New deal",
                    "New contract" => "New contract",
                    "New task" => "New task",
                    "New task comment" => "New task comment",
                    "New monthly payslip" => "New monthly payslip",
                    "New announcement" => "New announcement",
                    "New support ticket" => "New support ticket",
                    "New meeting" => "New meeting",
                    "New award" => "New award",
                    "New holiday" => "New holiday",
                    "New event" => "New event",
                    "New company policy" => "New company policy",
                    "New invoice" => "New invoice",
                    "New bill" => "New bill",
                    "New budget" => "New budget",
                    "New revenue" => "New revenue",
                    "New invoice payment" => "New invoice payment",
                ],
                'attr' => ['class' => 'form-select m-0'],
            ])
            ->add('URL',  TextType::class, [
                'label' => 'URL',
                'required' => 'required',
                'attr' => [
                    'class' => 'form-control m-0',
                    'placeholder' => 'Enter URL', 
                    'autocomplete' => 'off',
                ],
            ])
            ->add('method',  ChoiceType::class, [
                'choices' => [
                    'GET' => 'GET',
                    'POST' => 'POST'
                ],
                'attr' => ['class' => 'form-select m-0'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Webhook::class,
            'current_user' => null,
        ]);
    }
}
