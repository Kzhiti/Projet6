<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['label' => 'Nom de Compte'])
            ->add('nom')
            ->add('prenom')
            ->add('images', FileType::class, [
                'label' => 'Photo',
                'mapped' => false,
                'required' => false
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Entrez votre Mot de Passe',
                'required' => true
            ])
            ->add('Confirmer', SubmitType::class, [
                'attr' => ['class' => 'w-100 btn btn-primary btn-lg'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
