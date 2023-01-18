<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'auth__form--input'],
            ])
            ->add('firstname', TextType::class, [
                'attr' => ['class' => 'auth__form--input'],
            ])
            ->add('lastname', TextType::class, [
                'attr' => ['class' => 'auth__form--input'],
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Rol',
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => [
                    'Man' => 'Man',
                    'Vrouw' => 'Vrouw',
                ],
                'attr' => [
                    'class' => 'auth__form--input',
                ]
            ])
            ->add('adress', TextType::class, [
                'attr' => ['class' => 'auth__form--input'],
            ])
            ->add('postal', TextType::class, [
                'attr' => ['class' => 'auth__form--input'],
            ])
            ->add('city', TextType::class, [
                'attr' => ['class' => 'auth__form--input'],
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Rol',
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => [
                    'Admin' => 'ROLE_ADMIN',
                    'Instructeur' => 'ROLE_INSTRUCTOR',
                    'User' => 'ROLE_USER',
                ],
                'attr' => [
                    'class' => 'form__input',
                ]
            ])
        ;

        // Data transformer
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    return count($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {
                    return [$rolesString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
