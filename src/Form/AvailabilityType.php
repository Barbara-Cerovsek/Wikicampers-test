<?php

namespace App\Form;

use App\Entity\Vehicle;
use App\Entity\Availability;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AvailabilityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('vehicle', EntityType::class, [
                'class' => Vehicle::class,
                'choice_label' => function (Vehicle $vehicle): string {
                    return $vehicle->getBrand().' - '.$vehicle->getModel(); 
                },
                'label'=> 'Véhicule',
            ])

            ->add('start_date', null, [
                'widget' => 'single_text',
                'label'=> 'Date de départ',
            ])
            ->add('end_date', null, [
                'widget' => 'single_text',
                'label'=> 'Date de retour',
            ])
            ->add('price_per_day', null, [
                'label'=> 'Prix par jour (€)',
            ])
            ->add('status', null, [
                'label'=> 'Disponible',
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
            'data_class' => Availability::class,
        ]);
    }
}
