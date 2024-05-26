<?php

namespace App\Form;

use Assert\NotNull;
use App\Entity\Availability;
use App\Form\AvailabilityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    $builder
            ->add('start_date', DateTimeType::class, [ // shows date and time
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Date départ',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                
            ])
            ->add('end_date', DateTimeType::class, [
                'widget' => 'single_text',
                 'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Date retour',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                
           ])
            ->add('submit', SubmitType::class, [
                'attr' =>[
                    'class' => 'btn btn-info my-2'
                ],
                'label' => 'Chercher une disponibilité'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Availability::class,
        ]);
    }

}
