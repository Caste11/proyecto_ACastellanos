<?php

namespace App\Form;

use App\Entity\Cliente;
use App\Entity\Indicencia;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FormularioIncidenciasClienteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo')
            ->add('estado', ChoiceType::class, [
                'choices' => [
                    'Iniciada' => 'iniciada',
                    'En Proceso' => 'en_proceso',
                    'Resuelta' => 'resuelta',
                ],
                'placeholder' => 'Seleccionar Estado',
                'attr' => [
                    'class' => 'w-full px-3 py-2 border rounded-md',
                ],
            ])
            ->add('Submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Indicencia::class,
        ]);
    }
}
