<?php

namespace App\Form;

use App\Entity\CharClass;
use App\Entity\CharSide;
use App\Entity\User;
use App\Entity\UserGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('realName')
            ->add('nickName')
            ->add('email')
            ->add('charClass', EntityType::class, [
                'class' => CharClass::class,
                'choice_label' => 'name',
                'choice_translation_domain' => 'messages'
            ])
            ->add('charSide', EntityType::class, [
                'class' => CharSide::class,
                'choice_label' => 'name',
                'choice_translation_domain' => 'messages',
                'label' => 'Side'
            ])
            ->add('save', SubmitType::class, ['label' => 'Save', 'attr' => ['class' => 'btn-primary']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
