<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class DevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('Societe',TextType::class,[
               'label'=>'Société',
               'attr' => array(
                'placeholder' =>'Si vous ne vous n\'avez pas de société mettez juste -'
            ),
            'constraints' => [
                new NotBlank(
                    [
                        'message'=>'ce champ ne peut pas etre vide',
                    ]
                )
               ],
            ])
            ->add('NumeroDeRue',IntegerType::class,[
                'label'=>'Numéro de rue',
                'attr' => array(
                    'placeholder' =>'ex:76'
                ),
                'constraints' => [
                    new NotBlank(
                        [
                            'message'=>'ce champ ne peut pas etre vide',
                        ]
                    )
                   ],
                ])
            ->add('NomDeRue',TextType::class,[
                'label'=>'Nom de rue',
                'attr' => array(
                    'placeholder' =>'ex:Honegger'
                ),
                'constraints' => [
                    new NotBlank(
                        [
                            'message'=>'ce champ ne peut pas etre vide',
                        ]
                    )
                   ],
                ])
            ->add('CodePostale',IntegerType::class,[
                'label'=>'Code Postale',
                'attr' => array(
                    'placeholder' =>'ex:76600'
                ),
                'constraints' => [
                    new NotBlank(
                        [
                            'message'=>'ce champ ne peut pas etre vide',
                        ]
                    )
                   ],
                ])
            ->add('Ville',TextType::class,[
                'label'=>'Ville',
                'attr' => array(
                    'placeholder' =>'ex:Le havre'
                ),
                'constraints' => [
                    new NotBlank(
                        [
                            'message'=>'ce champ ne peut pas etre vide',
                        ]
                    )
                   ],
                ])
            ->add('pays',EntityType::class,[
                'class'=>'App\Entity\Pays',
                'label'=>'Pays',
                'attr' => array(
                    'placeholder' =>'ex:France'
                ),
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
            'data_class' => User::class,
        ]);
    }
}
