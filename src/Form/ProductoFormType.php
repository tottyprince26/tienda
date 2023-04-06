<?php

namespace App\Form;

use App\Entity\Producto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProductoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('descripcion')
            ->add('precio', NumberType::class)
            ->add('stock', NumberType::class)
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

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
            'accion' => 'insertar'
        ]);
    }
}
