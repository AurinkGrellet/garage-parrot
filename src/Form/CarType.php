<?php

namespace App\Form;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class, [
            'label' => 'Titre',
            'required' => true
        ])
        ->add('price', MoneyType::class, [
            'label' => 'Prix',
            'required' => true
        ])
        ->add('image', FileType::class, [
            'label' => 'Photo',
            'mapped' => false,
            'required' => true,
            'constraints' => [
                new File([
                    'maxSize' => '8192k',
                    'mimeTypes' => [
                        'image/png',
                        'image/jpeg',
                        'image/gif',
                        'image/ico',
                        'image/webp',
                        'image/bmp'
                    ],
                    'mimeTypesMessage' => "Veuillez sélectionner une image valide"
                ])
            ]
        ])
        ->add('year', DateType::class, [
            'label' => 'Année de mise en service',
            'required' => true,
            'years' => range(date('Y')-50, date('Y'))
        ])
        ->add('km', IntegerType::class, [
            'label' => 'Kilomètres',
            'required' => true
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Enregistrer'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class
        ]);
    }
}
