<?php

namespace App\Form;

use App\Entity\Tableformation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints\Image;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom_Formation',null,['attr'=>['autofocus'=>true]])
            ->add('DateDebTroisMois',DateType::class,[
                'attr'=>['autofocus'=>true],
                'label'=>"Date de début dans 3 mois",
                'constraints' => [
                  new NotBlank([
                      'message'=>'ce champ ne peut pas etre vide',
                  ])
                 ],
             ])
             ->add('DateDebSixMois',DateType::class,[
                'attr'=>['autofocus'=>true],
                'label'=>'Date de début dans 6 mois',
                'constraints' => [
                  new NotBlank([
                      'message'=>'ce champ ne peut pas etre vide',
                  ]),
                 ],
             ])
             ->add('DateDebUnAns',DateType::class,[
                'attr'=>['autofocus'=>true],
                'label'=>'Date de début dans 1 an',
                'constraints' => [
                  new NotBlank([
                      'message'=>'ce champ ne peut pas etre vide',
                  ]),
                 ],
             ])
            ->add('NombreJour',IntegerType::class,[
                'attr'=>['autofocus'=>true],
                'label'=>'Nombre de jours',
                'constraints' => [
                    new NotBlank([
                        'message'=>'ce champ ne peut pas etre vide',
                    ]),
                ],
            ])
            ->add('Disponibilite',ChoiceType::class, [
                'choices'  => [
                    'Jours' => 'Jour',
                    'Soir' => 'Soir',
                ],
                'constraints' => [
                    new NotBlank([
                        'message'=>'ce champ ne peut pas etre vide',
                    ]),
                ],
             ])
            ->add('Lieu',TextType::class,[
                'constraints' => [
                new NotBlank([
                    'message'=>'ce champ ne peut pas etre vide',
                         ]),
                    ],
            ])
            ->add('Prix',TextType::class,[
                'constraints' => [
                    new NotBlank([
                        'message'=>'ce champ ne peut pas etre vide',
                    ]),
                ],
            ])
            ->add('Description_formation',null,['attr'=>['rows'=>10,'cols'=>10]])
            ->add('objectif',TextareaType::class,['attr'=>['rows'=>10,'cols'=>10]])
            ->add('Prerequis',TextareaType::class,['attr'=>['rows'=>10,'cols'=>10]])
            ->add('imageFile', VichImageType::class, [
                'label'=>'Image (JPG,PNG... file)',
                'required' => false,
                'download_uri' => false,
                'constraints'=>[
                    new Image(['maxSize'=>'8M'])
                ],
                'imagine_pattern'=>'squared_thumbnail_small'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tableformation::class,
        ]);
    }
}
