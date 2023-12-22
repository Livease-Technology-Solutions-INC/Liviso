<?php

namespace App\Form;

use App\Entity\Zoom;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use App\Form\Account\DataTransformer\UserToIdTransformer;
use ContainerYIAPxIo\getCheckoutControllerService;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ZoomType extends AbstractType
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
        $id = $options['id'] ?? null;
        $builder
            ->add('title')
            ->add('project',  ChoiceType::class, [
                'choices' => [
                    'Automatic' => 'Automatic',
                ],
                'attr' => ['class' => 'form-select m-0'],
            ])
            ->add('user', ChoiceType::class, [
                'data' => $id,
                'data_class' => null,
                'mapped' => false,
                'choices' => $this->getUserChoices(),
                'attr' => ['class' => 'form-select m-0'],
            ])
            ->add('meetingTime', DateTimeType::class, [
                'label' => 'Meeting Time',
                'html5' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control m-0',
                    'placeholder' => 'Select Date/Time',
                    'required' => 'required',
                ],
            ])
            ->add('duration')
            ->add('meetingURL', TextType::class, [
                'label' => 'Meeting URL', 
                'autocomplete' => 'off',
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Soon' => 'Soon',
                    'Live' => 'Live',
                    'Ended' => 'Ended',
                ],
                'attr' => ['class' => 'form-select m-0'],
            ]);
        $builder->get('user')->addModelTransformer($this->userToIdTransformer);
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
            'data_class' => Zoom::class,
            'current_user' => null,
        ]);
    }
}
