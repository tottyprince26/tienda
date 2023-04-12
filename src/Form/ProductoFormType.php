<?php

namespace App\Form;

use App\Entity\Producto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProductoFormType extends AbstractType
{
    //metodo para crear el formulario de registro de productos
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('descripcion')
            ->add('precio', NumberType::class)
            ->add('stock', NumberType::class)
            ->add('imagen', FileType::class, [
                'label' => 'Imagen (JPEG, PNG o GIF)',
                'mapped' => false,
                'required' => false
            ]) 
            ->add('save', SubmitType::class, ['label' => 'Guardar'])    
        ;

        if($options['accion'] == 'editar')
        {
            $builder ->add('estado', ChoiceType::class,array (
                'choices' => array(
                    'Activo' => 'Activo',
                    'Inactivo' => 'Inactivo',
                )
                ));
        }
    }

    //metodo para configurar las opciones del formulario
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
            'accion' => 'insertar'
        ]);
    }
}
