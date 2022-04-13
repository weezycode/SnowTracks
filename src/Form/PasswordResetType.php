<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class PasswordResetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'options' => ['attr' => ['class' => 'password-field']],
            'required' => true,
            'first_options'  => ['label' => 'Mot de passe'],
            'second_options' => ['label' => 'Confimer le mot de passe '],
            'constraints' => [
                new Regex([
                    'pattern' => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{6,}$/",
                    'message' => "Votre mot de passe doit contenir au moins une lettre miniscule, une majucsule, un chiffre et un caractère espécial",
                ]),
                new Length([
                    'min' => 5,
                    'minMessage' => "Votre mot de passe doit avoir au moins 6 caractères",
                    'max' => "20",
                    'maxMessage' => "Votre mot de passe ne doit avoir au plus de 20 caractères"
                ])
            ],
        ]);
    }
}
