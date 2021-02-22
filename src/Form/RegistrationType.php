<?php

namespace App\Form;

use App\Entity\User;
use App\Form\AppType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationType extends AppType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      
        $builder
            ->add('first_name', TextType::class, $this->getConfig("Prénom", "Votre prénom ..."))
            ->add('last_name', TextType::class, $this->getConfig("Nom", "Votre nom ..."))
            ->add('email', EmailType::class, $this->getConfig("Email", "Votre Email ..."))
            ->add('avatar', UrlType::class, $this->getConfig("Avatar", "Url de votre avatar ..."))
            //->add('hash', PasswordType::class, $this->getConfig("Mot de passe", "Choisissez un mot de passe"))
            ->add('hash', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Veillez confirmer votre mot de passe',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmez votre mot de passe'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
