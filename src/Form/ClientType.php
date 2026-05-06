<?php

namespace App\Form;

use App\Entity\Client;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de client/Entreprise',
                'attr' => [
                    'placeholder' => '',
                ]
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => '',
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => 'Telephone',
                'attr' => [
                    'placeholder' => '',
                ]
            ])
            ->add('adress', TextType::class, [
                'label' => 'Adress',
                'attr' => [
                    'placeholder' => '',
                ]
            ])
            ->add('siret', TextType::class, [
                'label' => 'SIRET(Optionnel)',
                'required' => false,
                'attr' => [
                    'placeholder' => '',
                ]
            ])
            ->add('rib', TextType::class, [
                'label' => 'RIB(Optionnel)',
                'required' => false,
                'attr' => [
                    'placeholder' => '',
                ]
            ])
            // ->add('owner', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            // 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
