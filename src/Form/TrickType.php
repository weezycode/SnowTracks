<?php

namespace App\Form;

use App\Entity\Trick;
use App\Entity\Groupe;
use App\Form\VideoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Le nom du Trick', 'required' => true])
            ->add('content', TextareaType::class, ['label' => 'Description', 'required' => true])
            ->add('groupe', EntityType::class, [
                'class' => Groupe::class,
                'choice_label' => 'name',
                'attr' => ['readonly' => true],
                'required' => true,
                'empty_data' => false,
                'label' => 'Selectionner un groupe'
            ])

            ->add('image', FileType::class, [
                'required' => false,
                'label' => false,
                'mapped' => false,
                'multiple' => true,
            ])

            ->add('videos', CollectionType::class, [
                'entry_type' => VideoType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'required' => false,
                'prototype' => true,
                'label' => false,

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
