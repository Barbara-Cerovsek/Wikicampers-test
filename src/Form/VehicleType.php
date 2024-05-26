<?php

namespace App\Form;

use App\Entity\Vehicle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class VehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('brand', TextType::class, [
            'attr' => [
                'class' => 'form-control' // full width input field
            ],
            'label' => 'Marque' // it changes the label name
          
        ])
        ->add('model', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label' => 'Modèle'
            
        ])
        ->add('submit', SubmitType::class, [
            'attr' =>[
                'class' => 'btn btn-info my-2'
            ],
            'label' => 'Valider'
        ])
    ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}
