<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AnnonceType extends AbstractType
{
    /**
     * Permet de confiurer un form
     *
     * @param [string] $label
     * @param [string] $placeholder
     * @param  array $options
     * @return array
     */
    private function getConfiguration($label, $placeholder, $options = []){
        return array_merge([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
            ], $options);
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration('Titre', "Donner un superbe titre à votre annonce..."))
            ->add('slug', TextType::class, $this->getConfiguration("Addresse web", "Automatique pas de saisie",[
                'required' => false
            ]))
            ->add('coverImage', UrlType::class, $this->getConfiguration('Url de l\'image', "Entrer une url de l'image en question..."))
            ->add('introduction', TextType::class, $this->getConfiguration('Introduction', "Donnez une description globale de votre annonce"))
            ->add('content', TextareaType::class, $this->getConfiguration('Description détaillée', "Tapez une description qui donne vraiment envie de venir chez vous"))
            ->add('rooms', IntegerType::class, $this->getConfiguration('Nombre de chambres', "Le nombre de chambre "))
            ->add('price', MoneyType::class, $this->getConfiguration('Prix par nuit', "Donnez le prix par nuit de votre chambre"))
            ->add(
                'images', 
                CollectionType::class,
                [
                    'entry_type' =>ImageType::class,
                    'allow_add' => true,
                    'allow_delete' => true
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
            [
                'entry_type' =>ImageType::class
            ]
        ]);
    }
}
