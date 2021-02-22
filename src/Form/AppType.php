<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

class AppType extends AbstractType{
     /**
         * La config de base
         * 
         * @param string $label
         * @param string $placeholder
         * @param string $options
         * @return array
         */
        protected function getConfig($label, $placeholder, $options = []){
            return array_merge([
                'label' => $label,
                'attr' => ['placeholder' => $placeholder]
            ], $options);
        }
}