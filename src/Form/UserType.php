<?php

namespace App\Form;

use App\Entity\CharClass;
use App\Entity\CharSide;
use App\Entity\CV;
use App\Entity\User;
use App\Entity\UserGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nickName')
            ->add('userRole', EntityType::class, [
                'class' => UserGroup::class,
                'choice_label' => 'name',
                'choice_translation_domain' => 'messages',
            ])
            ->add('charClass', EntityType::class, [
                'class' => CharClass::class,
                'choice_label' => 'name',
                'choice_translation_domain' => 'messages'
            ])
            ->add('level', ChoiceType::class, [
                'label' => 'Char level',
                'choices' => array_flip(CV::$levels),
                'attr' => [
                    'placeholder' => 'Char level'
                ]
            ])
            ->add('charSide', EntityType::class, [
                'class' => CharSide::class,
                'choice_label' => 'name',
                'choice_translation_domain' => 'messages',
                'label' => 'Side'
            ])
            ->add('excluded', CheckboxType::class, ['label' => 'Excluded from guild', 'required' => false])
            ->add('plainPassword', PasswordType::class, ['required' => false, 'label' => false, 'attr' => ['placeholder' => 'Password'], 'help' => "Заполняйте поле пароля только если Вы хотите ИЗМЕНИТЬ ТЕКУЩИЙ ПАРОЛЬ"])
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
