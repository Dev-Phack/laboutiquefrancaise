<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre Prénom',
                'constraints' => new Length(['min' => 2, 'max' => 60]),
                'attr' => [
                    'placeholder' => 'Merci d\'entrer votre prénom'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre Nom',
                'constraints' => new Length(['min' => 2, 'max' => 30]),
                'attr' => [
                    'placeholder' => 'Merci d\'entrer votre nom'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre Email',
                'constraints' => new Length(['min' => 2, 'max' => 60]),
                'attr' => [
                    'placeholder' => 'Merci d\'entrer votre adresse mail'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux champs de mot de passe doivent être identiques',
                // 'mapped' => false,
                'required' => true,
//                'constraints' => new Length(['min' => 8, 'max' => 24]),
                'first_options' => ['label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de saisir un mot de passe'
                    ]
                ],
                'second_options' => ['label' => 'Confirmez le mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de confirmer le mot de passe'
                    ]
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
