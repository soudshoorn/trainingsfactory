<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'attr'  => ['class' => 'form__input']
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
