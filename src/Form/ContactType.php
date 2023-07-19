<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject', TextType::class, array(
                'label'=> 'Sujet',
                'attr' => array(
                    'class' => 'form-control',
                    'style' => 'margin-bottom:6px')))
            ->add('firstname', TextType::class, array(
                'label'=> 'Prénom',
                'attr' => array(
                    'class' => 'form-control',
                    'style' => 'margin-bottom:6px')))
            ->add('name', TextType::class, array(
                'label'=> 'Nom',
                'attr' => array(
                    'class' => 'form-control',
                    'style' => 'margin-bottom:6px')))
            ->add('email', TextType::class, array(
                'label'=> 'E-mail',
                'attr' => array(
                     'class' => 'form-control',
                    'style' => 'margin-bottom:6px')))
            ->add('phone', TextType::class, array(
                'label' => 'Téléphone',
                'attr' => array(
                    'class' => 'form-control',
                    'style' => 'margin-bottom:6px'
                )
            ))
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn',
                    'style' => 'margin-top:10px; margin-bottom:15px; background-color:#262526; color:#F2F2F2;'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
