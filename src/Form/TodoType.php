<?php

namespace App\Form;

use App\Entity\Color;
use App\Entity\Status;
use App\Entity\Todo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'todo-form-control',
                    'placeholder' => 'Entrez un titre...'
                ],
                'label' => 'Titre'
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'todo-form-control',
                    'placeholder' => 'Ecrivez votre description de la tâche...' 
                ],
                'label' => 'Description',
            ])
            ->add('color', EntityType::class, [
                'class' => Color::class,
                'label' => 'Couleur'
            ])
            ->add('status', EntityType::class, [
                'class' => Status::class,
                'expanded' => true,
                'multiple' => false,
                'label' => 'Statut'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Todo::class,
        ]);
    }
}
