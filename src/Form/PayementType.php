<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PayementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           
            ->add('Name',TextType::class,[
                'label' => 'Nom sur la carte',
                'attr' => array(
                    'placeholder' =>'ex:johon'
                ),
                ])
            ->add('NumeroCarte',IntegerType::class,[
                'label' => 'Numéro de la carte'
            ])
            ->add('Crypto',IntegerType::class,[
                'label' => 'Crypthograme'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
