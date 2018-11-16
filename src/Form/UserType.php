<?php

namespace App\Form;

use App\Entity\CharClass;
use App\Entity\User;
use App\Entity\UserGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
