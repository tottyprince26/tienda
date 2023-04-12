<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class UserType extends AbstractType{
    
    //metodo para crear el formulario de registro de usuarios
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', emailType ::class , array('label' => 'Email'))
            ->add('password', passwordType ::class , array('label' => 'Contraseña'), array('attr' => array('minlength' => 8)), array('attr' => array('maxlength' => 16)))
            ->add('save', submitType ::class , array('label' => 'GUARDAR'))
            ;

           if('accion' == 'editar')
            {
                $builder
                    ->add('estado', ChoiceType::class, array(
                        'label' => 'Estado',
                        'choices' => array(
                            'Activo' => 'Activo',
                            'Inactivo' => 'Inactivo',
                        )
                    ))
                    ->add('roles', ChoiceType::class, array(
                        'label' => 'Roles',
                        'choices' => array(
                            'Administrador' => 'ROLE_ADMIN',
                            'Cliente' => 'ROLE_USER',
                        ),
                        'multiple' => true,
                        'expanded' => true,
                        'placeholder' => 'Seleccione un rol',
                        'required' => true,
                    ));
            }
    }
    
    //metodo para configurar las opciones del formulario
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'accion' => 'registrarse'
        ]);
    }
}
