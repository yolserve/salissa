<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Beneficiary;
use App\Entity\UserAccount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfonycasts\DynamicForms\DependentField;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfonycasts\DynamicForms\DynamicFormBuilder;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BeneficiaryForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder = new DynamicFormBuilder($builder);

        $builder
            ->add('organisationType', ChoiceType::class, [
                'label'=> 'Type d\'organisation',
                'placeholder' => 'Sélectionnez le type de compte',
                'required' => true,
                'choices' => [
                    'Association' => 'association',
                    'Entreprise' => 'entreprise',
                    'Collectivité' => 'collectivite',
                    'Particulier' => 'particulier',
                ],
                'constraints' => [
                    new Choice([
                        'choices' => ['association', 'entreprise', 'collectivite', 'particulier'],
                        'message' => 'Veuillez sélectionner un type d\'organisation valide.',
                    ]),
                ],
            ])
            ->add('phoneNumber', TelType::class)
            ->add('userAccount', RegistrationForm::class, [

            ]);
        $builder->addDependent('lastname', 'organisationType', function (DependentField $field, ?string $organisationType) {
            if($organisationType === 'particulier'){

                $field->add(TextType::class, [
                    'label' => 'Nom'
                ]);
            }
        })
            ->addDependent('firstname', 'organisationType', function (DependentField $field, ?string $organisationType) {
                if($organisationType === 'particulier'){

                    $field->add(TextType::class, [
                        'label' => 'Prénom'
                    ]);
                }
            })
            ->addDependent('socialReason', 'organisationType', function (DependentField $field, ?string $organisationType) {
                if($organisationType !== 'particulier'){

                    $field->add(TextType::class, [
                        'label' => 'Raison sociale'
                    ]);
                }
            })
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Beneficiary::class,
        ]);
    }
}
