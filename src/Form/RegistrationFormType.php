<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
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
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'attr' => ['class' => 'auth__form--checkbox'],
                'constraints' => [
                    new IsTrue([
                        'message' => 'Je moet eerst akkoord gaan met onze voorwaarden.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', 'class' => 'auth__form--input'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
