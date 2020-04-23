<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationType extends ApplicationType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class,$this->getConfiguration('Prenom', 'Entrer votre prenom'))
            ->add('lastName', TextType::class, $this->getConfiguration('Nom', 'Entrer votre nom'))
            ->add('email', EmailType::class, $this->getConfiguration('Email', 'Entrer votre email'))
            ->add('picture', UrlType::class, $this->getConfiguration('Url de l\'image ', 'Entrer l\'url de l\'avatar'))
            ->add('hash', PasswordType::class, $this->getConfiguration('Mots de passe', 'Entrez votre mots de passe'))
            ->add('confirmPassword', PasswordType::class, $this->getConfiguration('Confirmer le mots de passe','Veuillez confirmer le mots de passe'))
            ->add('introduction', TextareaType::class, $this->getConfiguration('Introdcution', 'Une introduction'))
            ->add('description', TextareaType::class, $this->getConfiguration('Description','Donnez une description de vous !'))
            ->add('slug', TextType::class, $this->getConfiguration('Slug','Tapez votre Slug'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
