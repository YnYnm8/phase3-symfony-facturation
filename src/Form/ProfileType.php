<?php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('company_name', TextType::class, [
                'label' => 'Raison Sociale',
                'attr' => [
                    'placeholder' => 'Tech Solutions',
                ],
                'help' => 'Le nom de votre entreprise qui apparaîtra sur vos factures.',
            ])
            ->add('siret', TextType::class, [  
                'label' => 'Numéro SIRET (Optionnel)',
                'required' => false,
                'attr' => [
                    'placeholder' => '362 521 879 00034',
                ],
            ])
            ->add('iban', TextType::class, [    
                'label' => 'IBAN',
                'attr' => [
                    'placeholder' => 'FR76 1234 5678 9012 3456 7890 123',
                ],
                'help' => 'Compte bancaire qui recevra les virements de vos clients.',
            ])
            ->add('cgv', TextareaType::class, [ 
                'label' => 'Conditions Générales de Vente (CGV)', 
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ces conditions apparaîtront en bas de vos factures PDF...',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}