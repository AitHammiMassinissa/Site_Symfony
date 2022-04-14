<?php

namespace App\Form;

use App\Entity\Tableformation;
use App\Entity\User;
use App\Validator\Telephone;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Blank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProposeDateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('DateD',DateType::class,[
                'label'=>'Date début',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez remplir ce champ',
                    ]),
                ],
                ])
            ->add('Disponibilite',ChoiceType::class,[
                    'label'=>'Disponibilité',
                    'choices'  => [
                        'Jours' => 'Jours',
                        'Soir' => 'Soir',
                    ],
                    'attr' => array(
                        'placeholder' =>'ex:soir'
                    ),
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez remplir ce champ',
                        ]),
                    ],
                    ])
            ->add('NombreP',IntegerType::class,[
                'label'=>'Nombre de personnes',
                'attr' => array(
                    'placeholder' =>'ex:1'
                ),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez remplir ce champ',
                    ]),
                ],
                ])
            ->add('Nom',TextType::class,[
                'label'=>'Nom',
                'attr' => array(
                    'placeholder' =>'ex:John'
                ),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez remplir ce champ',
                    ]),
                ],
                ])
            ->add('Prenom',TextType::class,[
                'label'=>'Prénom',
                'attr' => array(
                    'placeholder' =>'ex:do'
                ),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez remplir ce champ',
                    ]),
                ],
                ])
            ->add('email',null,[
                'label'=>'Email',
                'attr' => array(
                    'placeholder' => 'ex:johndo@gmail.com'
                ),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez remplir ce champ',
                    ]),
                    new Email([
                       'message' => 'Veuillez entrer une adresse mail valide'
                    ]),
                ],
            
            ])
            ->add('Telephone',null,[
                'label'=>'Numéro de téléphone',
                'attr' => array(
                    'placeholder' => '0781564586'
                ),
                'constraints' => [
                    new Telephone([
                        'message' => 'Numéro de téléphone non valide',
                    ]),
                    new NotBlank([
                        'message' => 'Se champ ne peut pas etre null',
                    ]),
                    
                ],
              
            ])
            ->add('Fonction',TextType::class,[
                'label'=>'Fonction',
                'attr' => array(
                    'placeholder' =>'ex:Salarié'
                ),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez remplir ce champ',
                    ]),
                ],
                ])
            ->add('Societe',TextType::class,[
                'label'=>'Société',
                'attr' => array(
                    'placeholder' =>'ex:Si vous n\'avez pas de société mettez -'
                ),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez remplir ce champ',
                    ]),
                ],
            ])
            ->add('Message',TextareaType::class,[
                'attr'=>[
                    'rows'=>5,'cols'=>5,
                    'placeholder' =>'Ceci est un message pour Solway Consulting & Services '
                ],
                'label'=>'Message'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           
        ]);
    }
}
