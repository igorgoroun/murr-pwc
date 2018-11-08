<?php

namespace App\Form;

use App\Entity\GVG;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GVGType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'years' => date('Y')==date('Y', strtotime('Sunday'))?[date('Y')]:range(date('Y'), date('Y')+1),
                'months' => date('m')==date('m', strtotime('Sunday'))?[date('m')]:range(date('m'), date('m')+1),
                'days' => range(date('d', strtotime('Friday')), date('d', strtotime('Sunday')))
            ])
            ->add('time', TimeType::class, [
                'hours' => [20, 14, 13],
                'minutes' => range(0,30,3)
            ])
            ->add('enemy', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Enemy'
                ]
            ])
            ->add('territory', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Territory'
                ]
            ])
            ->add('hint', TextareaType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => "Hint",
                ]
            ])
            ->add('save', SubmitType::class, ['label' => 'Save', 'attr' => ['class' => 'btn-primary']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GVG::class,
        ]);
    }
}
