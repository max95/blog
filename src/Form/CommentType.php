<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contenu', null, [
                'label' => 'Votre commentaire'
            ])
            #->add('dateComment') Function __construct ajoutée à Comment.php
            ->add('author', null, [
                'label' => 'Votre nom'
            ])
            #->add('article') Pas besoin car on sait deja sur quel article on se trouve
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
