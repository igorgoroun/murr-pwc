<?php

namespace App\Form;

use App\Entity\CharClass;
use App\Entity\CharSide;
use App\Entity\CV;
use App\Entity\User;
use App\Entity\UserGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('realName', TextType::class, [
                'label' => false,
            ])
            ->add('nickName', TextType::class, [
                'label' => false,
            ])
            ->add('email', TextType::class, [
                'label' => 'Profile'
            ])
            ->add('plainPassword', PasswordType::class, [
                'required' => false,
                'label' => false,
                'attr' => ['placeholder' => 'Password'],
                'help' => "Заполняйте поле пароля только если Вы хотите ИЗМЕНИТЬ ТЕКУЩИЙ ПАРОЛЬ"
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
            ->add('subscription', TextareaType::class, [
                'label' => 'Subscription',
                'attr' => [
                    'rows' => 4
                ],
                'help' => "Можно использовать разметку Markdown"
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
