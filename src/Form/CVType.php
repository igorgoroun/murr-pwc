<?php

namespace App\Form;

use App\Entity\CV;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CVType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('age')
            ->add('region')
            ->add('twins')
            ->add('gvgExperience')
            ->add('previousExits')
            ->add('ourReasons')
            ->add('guarantors')
            ->add('confirmStatement')
            ->add('charClass')
            ->add('user')
            ->add('charSide')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CV::class,
        ]);
    }
}
