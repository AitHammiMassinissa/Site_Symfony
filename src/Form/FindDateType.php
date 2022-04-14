<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class FindDateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Periode',ChoiceType::class,[
                'label'=>'Période',
                'attr' => array(
                    'placeholder' =>'Trouver une periode'
                ),
                'choices'  => [
                    'Dans 3 mois' => 'Dans 3 mois',
                    'Dans 6 mois' => 'Dans 6 mois',
                    'Dans 1 ans'  => 'Dans 1 an',
                ],
                'constraints' => [
                    new NotBlank(
                        [
                            'message'=>'ce champ ne peut pas etre vide',
                        ]
                    )
                   ],
            ])
            ->add('Mode',ChoiceType::class,[
                'label'=>'Mode de formation',
                'attr' => array(
                    'placeholder' =>'Trouver une mode'
                ),
                'choices'  => [
                    'Île-de-France' => 'Île-de-France',
                    'Distanciel' => 'Distanciel',
                ],
                'constraints' => [
                    new NotBlank(
                        [
                            'message'=>'ce champ ne peut pas etre vide',
                        ]
                    )
                   ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
