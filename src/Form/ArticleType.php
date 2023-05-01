<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', null, [
                'attr' => [
                    'placeholder' => "Ajouter un titre à l'article"
                ]
            ])
            ->add('contenu')
            ->add('dateCreation', null, [
                'widget' => 'single_text'])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'expanded' => false,
                'multiple' => true,
                'by_reference' => false,
                'required'   => false])
            ->add('brouillon', SubmitType::class,[
                'label' => 'Enregistrer en brouillon'
            ])
            ->add('publie', SubmitType::class,[
                'label' => 'Publier'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class, [
                'label' => 'Enregistrer en brouillon'
            ]
        ]);
    }
}
