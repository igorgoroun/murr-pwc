<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nickName', TextType::class, ['label' => false, 'attr' => ['placeholder' => 'Nickname']])
            ->add('realName', TextType::class, ['label' => false, 'attr' => ['placeholder' => 'Real name']])
            ->add('email', EmailType::class, ['label' => false, 'attr' => ['placeholder' => 'Email']])
            ->add('password', PasswordType::class, ['label' => false, 'attr' => ['placeholder' => 'Password']])
            ->add('save', SubmitType::class, ['label' => 'Sign up', 'attr' => ['class' => 'btn-primary']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
