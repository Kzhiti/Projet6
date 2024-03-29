<?php

namespace App\Form;

use App\Entity\Tricks;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('description', TextareaType::class, [
                'attr' => ['onInput' => 'this.parentNode.dataset.replicatedValue = this.value'],
            ])
            ->add('category', ChoiceType::class, [
                'label' => 'Categorie',
                'choices' => [
                    'Grabs' => "Grabs",
                    'Rotations' => "Rotations",
                    'Flips' => "Flips",
                    'Rotation Désaxée' => "Rotation Désaxée",
                    'Slides' => "Slides",
                    'Old School' => "Old School",
                    'One Foot Trick' => "One Foot Trick"
                ],
            ])
          ->add('videos', CollectionType::class, [
              'entry_type' => VideoType::class,
              'allow_add' => true,
              'allow_delete' => true,
              'prototype' => true
          ])
            ->add('images', FileType::class, [
                'label' => 'Images',
                'mapped' => false,
                'multiple' => true
            ])
            ->add('Confirmer', SubmitType::class, [
                'attr' => ['class' => 'w-100 btn btn-primary btn-lg'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tricks::class,
        ]);
    }
}
