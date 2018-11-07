<?php

namespace App\Form;

use App\Entity\CharClass;
use App\Entity\CharSide;
use App\Entity\CV;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CVType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('charClass', EntityType::class, [
                'class' => CharClass::class,
                'choice_label' => 'name',
                'choice_translation_domain' => 'messages',
            ])
            ->add('charSide', EntityType::class, [
                'label' => 'Side',
                'class' => CharSide::class,
                'choice_label' => 'name',
                'choice_translation_domain' => 'messages',
            ])
            ->add('level', ChoiceType::class, [
                'label' => 'Char level',
                'choices' => [
                    '30+' => 3,
                    '40+' => 4,
                    '50+' => 5,
                    '60+' => 6,
                    '70+' => 7,
                    '80+' => 8,
                    '90+' => 9,
                    '100+' => 10
                ],
                'attr' => [
                    'placeholder' => 'Char level'
                ]
            ])
            ->add('age', ChoiceType::class, [
                'choices' => [
                    'Less than 18' => 0,
                    'From 18 to 29' => 1,
                    '30 and more' => 2
                ],
            ])
            ->add('region', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => "Country / City"
                ]
            ])
            ->add('twins', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => "Twins",
                ],
                'help' => "twins_help"
            ])
            ->add('gvgExperience', CheckboxType::class, ['label' => 'GVG Experience', 'required' => false])
            ->add('previousExits', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => "Previous guilds",
                ],
                'help' => "previous_guilds_help"
            ])
            ->add('ourReasons', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => "Reasons",
                ],
            ])
            ->add('guarantors', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => "Guarantors",
                ],
                'help' => "guarantors_help"
            ])
            ->add('confirmStatement', CheckboxType::class, ['label' => 'Confirm Statement'])
            ->add('save', SubmitType::class, ['label' => 'Send', 'attr' => ['class' => 'btn-primary']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CV::class,
        ]);
    }
}
