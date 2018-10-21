<?php

namespace App\Form;

use App\Entity\Page;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label'=>false, 'attr' => ['placeholder'=>'Name']])
            ->add('title', TextType::class, ['label'=>false, 'attr' => ['placeholder'=>'Title (full name)']])
            ->add('active', CheckboxType::class, ['label'=>'Show page', 'required'=>false])
            ->add('body', TextareaType::class, ['label'=>false, 'required'=>false])
            ->add('save', SubmitType::class, ['attr' => ['class'=>'btn-primary']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
