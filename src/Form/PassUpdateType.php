<?php

namespace App\Form;

use App\Form\AppType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PassUpdateType extends AppType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPass', PasswordType::class, $this->getConfig('Ancien mot de passe', 'Entrez votre mot de passe actuel ...'))
            ->add('newPass', PasswordType::class, $this->getConfig('Nouveau mot de passe', 'Entrez votre nouveau mot de passe ...'))
            ->add('confirmPass', PasswordType::class, $this->getConfig('Confirmation', 'Confirmez votre mot de passe ...'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
