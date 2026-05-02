<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use App\Enum\ProductUnit;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Développement Web',
                ]
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => [
                    'texteria' => 'Création de site internet sur mesure'
                ]
            ])
            ->add('price', TextType::class, [
                'label' => 'Prix',
                'attr' => [
                    'placeholder' => '450€'
                ]
            ])
            ->add('unit', ChoiceType::class, [
                'label' => 'Unité',
                'choices' => [
                    'Prix'  => ProductUnit::PRICE,
                    'Heure' => ProductUnit::HOUR,
                    'Jour'  => ProductUnit::DAY,
                    'Mois'  => ProductUnit::MONTH,
                    'Année' => ProductUnit::YEAR,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
