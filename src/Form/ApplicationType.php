<?php 
namespace App\Form;

use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType{
    
    /**
     * Permet de confiurer un form
     *
     * @param [string] $label
     * @param [string] $placeholder
     * @param  array $options
     * @return array
     */
    protected function getConfiguration($label, $placeholder, $options = []){
        return array_merge([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
            ], $options);
    }

}