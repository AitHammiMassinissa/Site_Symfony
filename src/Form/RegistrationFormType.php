<?php

namespace App\Form;

use App\Entity\User;
use App\Validator\Telephone;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Blank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',null,[
            'label' => 'Prénom',
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
                'label' => 'Nom',
                'attr' => array(
                    'placeholder' => 'ex:do'
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
            ->add('numero',null,[
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
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label'=>'Conditions générale',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'Mot de passe',
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
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
