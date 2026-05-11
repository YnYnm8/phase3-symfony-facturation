<?php

namespace App\Form;


use App\Entity\Client;
use App\Entity\Invoice;
// use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('number')
            // ->add('total_ttc')
            // ->add('status')
            // ->add('owner', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            // ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'name',
            ])
            // ->add('created_at', EntityType::class, [
            //     'label' => 'date de la facture',
            //     'attr' => [
            //         'placeholder' => '',
            //     ]
            // ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
        ]);
    }
}
