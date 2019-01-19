<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setMethod('GET');
        $builder
            ->add(
                'showGuests',
                SubmitType::class,
                ['label' => 'Guest', 'attr' => ['class' => 'btn btn-outline-success']]
            )
            ->add(
                'showMembers',
                SubmitType::class,
                ['label' => 'Member', 'attr' => ['class' => 'btn btn-outline-success']]
            )
            ->add(
                'showOfficers',
                SubmitType::class,
                ['label' => 'Officer', 'attr' => ['class' => 'btn btn-outline-success']]
            )
            ->add(
                'showExcluded',
                SubmitType::class,
                ['label' => 'Excluded from guild', 'attr' => ['class' => 'btn btn-outline-danger']]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }

    public function getBlockPrefix()
    {
        return 'murr_user_filter';
    }

}
