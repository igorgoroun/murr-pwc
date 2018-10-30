<?php

namespace App\Form;

use App\Entity\ForumTopic;
use App\Entity\UserGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForumTopicEditorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('heading')
            ->add('description')
            ->add('postBody')
            ->add('sign')
            ->add('pickedTop')
            ->add('user')
            ->add('directory')
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
            'data_class' => ForumTopic::class,
        ]);
    }
}
