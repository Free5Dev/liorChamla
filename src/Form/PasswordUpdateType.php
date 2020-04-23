<?php

namespace App\Form;

use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PasswordUpdateType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, $this->getConfiguration('Ancien mots de passe', 'Veuillez entrer votre ancien mots de passe'))
            ->add('newPassword', PasswordType::class, $this->getConfiguration('Nouveau mots de passe', 'Veuillez entrer votre Nouveau mots de passe'))
            ->add('confirmPassword', PasswordType::class, $this->getConfiguration('confirmer le  mots de passe', 'Veuillez confirmer votre nouveau mots de passe'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
