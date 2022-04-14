<?php

namespace App\Form;

use App\Entity\User;
use App\Validator\Telephone;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',null,[
                'label'=>'Prénom',
                'attr' => array(
                    'placeholder' => 'ex:Jhon'
                ),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez remplir ce champ',
                    ]),
                ],
            ])
            ->add('lastName',null,[
                'label'=>'Nom',
                'attr' => array(
                    'placeholder' => 'ex:do'
                ),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez remplir ce champ',
                    ]),
                ],
            ])
            ->add('civilite',ChoiceType::class, [
                    'choices'  => [
                        'M' => 'Monsieur',
                        'Mme' => 'Madame',
                    ],
                    'label'=>'Choisissez votre civilité',
                    'attr' => array(
                        'placeholder' => 'Madame /Monsieur'
                    ),
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez remplir ce champ',
                        ]),
                    ],
                ]
            )
            ->add('numero',TextType::class,[
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
            ->add('email',EmailType::class,[
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
