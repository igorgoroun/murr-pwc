<?php

namespace App\Form;

use App\Entity\Forum;
use App\Entity\ForumDirectory;
use App\Entity\UserGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForumDirectoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Header'])
            ->add('forum', EntityType::class, [
                'class' => Forum::class,
                'choice_label' => 'name',
                'choice_translation_domain' => 'messages',
            ])
            ->add('access', EntityType::class, [
                'class' => UserGroup::class,
                'choice_label' => 'name',
                'choice_translation_domain' => 'messages',
            ])
            ->add('save', SubmitType::class, ['label' => 'Save', 'attr' => ['class' => 'btn-primary']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ForumDirectory::class,
        ]);
    }
}
