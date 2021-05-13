<?php

namespace App\Form;

use App\Entity\Tricks;
use Symfony\Component\Form\AbstractType;
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
            ->add('description')
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
            ->add('videos', VideoType::class, [
                'data_class' => null,
                'label' => false,
                'required' => false,
            ])
            ->add('images', FileType::class, [
                'label' => 'Images',
                'mapped' => false,
                'required' => false,
                'multiple' => true
            ])
            ->add('Confirmer', SubmitType::class, [
                'attr' => ['class' => 'submit'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tricks::class,
        ]);
    }
}
