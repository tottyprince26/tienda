<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', emailType ::class , array('label' => 'Email'))
            #->add('roles')
            #->add('estado') //tamaño de la contraseña
            ->add('password', passwordType ::class , array('label' => 'Contraseña'), array('attr' => array('minlength' => 8)), array('attr' => array('maxlength' => 16)))
            ->add('save', submitType ::class , array('label' => 'Ingresar'))
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
