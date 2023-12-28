<?php

namespace App\Form\HRMSystem;

use App\Entity\HRMSystem\ManageLeave;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Form\Account\DataTransformer\UserToIdTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ManageLeaveType extends AbstractType
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
            ->add('employee',  ChoiceType::class, [
                'choices' => $this->getUserChoices(),
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
            'data_class' => ManageLeave::class,
            'current_user' => null,
        ]);
    }
}
