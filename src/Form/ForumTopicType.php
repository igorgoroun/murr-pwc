<?php

namespace App\Form;

use App\Entity\ForumTopic;
use App\Entity\UserGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForumTopicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('heading', TextType::class, ['label' => false, 'attr' => ['placeholder' => 'Header']])
            ->add('description', TextType::class, ['label' => false, 'attr' => ['placeholder' => 'Description']])
            ->add('postBody', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'rows' => 10
                ]
            ])
            ->add('sign', CheckboxType::class, ['label' => 'Use sign', 'required' => false])
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
