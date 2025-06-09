<?php

namespace App\Form;

use App\Entity\Payment;
use App\Entity\Donation;
use Ehyiah\QuillJsBundle\Form\QuillType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class DonationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('amount', MoneyType::class, [
                'currency' => 'XAF'
            ])
            ->add('donatorFullName', TextType::class, [
                'label'=> 'Votre nom',
            ])
            ->add('anonymous', CheckboxType::class, [
                'label'=> 'Rendre la participation anonyme',
                ])
            ->add('comment', QuillType::class,)
            ->add('payment', PaymentForm::class)
            ->add('agreeTerms', CheckboxType::class, [
                'label'=> 'J\'accepte les CGU de salissa',
                'mapped' =>false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Donation::class,
        ]);
    }
}
