<?php

namespace App\Form;

use App\Classes\Form\FormConst;
use App\Classes\Inscription\ListesInscription;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Mail')
            ->add('Genre', ChoiceType::class,['choices' => FormConst::CIVILITE])
            ->add('Adresse1')
            ->add('Adresse2')
            ->add('CodePostal')
            ->add('Ville')
            ->add('Profession')
            ->add('DateNaissance', DateType::class, [
                'widget' => 'single_text',
                'html5'  => false,
            ])
            ->add('TelFix')
            ->add('TelPort')
            ->add('fEtudiant',CheckboxType::class)
            ->add('NiveauSca', ChoiceType::class, [
                'choices' => FormConst::NIVEAUXSCA
            ])
            ->add('NiveauApn', ChoiceType::class, [
                'choices' => FormConst::NIVEAUXAPN
            ])
            ->add('Diplomes',DiplomesType::class)
            ->add('Activite', ChoiceType::class, [
                'choices' => [
                    '--' => '--',
                    'Activités Scaphandre' => FormConst::ACTIVITESSCA,
                    'Activités Nage'       => FormConst::ACTIVITESDIV,
                    'Activités Apnée'      => FormConst::ACTIVITESAPN,
                    'Activités Encadrement'=> FormConst::ACTIVITESENC,
                ]
            ])
            ->add('fApneeSca',CheckboxType::class)
            ->add('fBenevole', CheckboxType::class)
            ->add('AccidentNom')
            ->add('AccidentPrenom')
            ->add('AccidentTelFix')
            ->add('AccidentTelPort')
            ->add('DateCertif', DateType::class, [
                'widget' => 'single_text',
                'html5'  => false
            ])
            ->add('fAllergAspirine', ChoiceType::class, [
                'choices' => FormConst::OUINON
            ])
            ->add('fLicence', CheckboxType::class)
            ->add('Assurance', ChoiceType::class, [
                'choices' => [
                    '--'          => '',
                    'Loisir Base' => FormConst::AXABASE,
                    'Loisir Top'  => FormConst::AXATOP,
                    'Autres'     => FormConst::AXAPISC
                ]
            ])
            ->add('ReducFam')
            ->add('fMailGUC', ChoiceType::class, [
                'choices' => FormConst::OUINON
            ])
            ->add('Facture', ChoiceType::class, [
                'choices' => FormConst::FACTURE
            ])
            ->add('PretMateriel', ChoiceType::class, [
                'choices' => FormConst::OUINON
            ])
            ->add('MineurNom')
            ->add('MineurPrenom')
            ->add('MineurQualite', ChoiceType::class, [
                'choices' => FormConst::PEREMERE
            ])
            ->add('MineurSign', CheckboxType::class)
            ->add('ReglementRGPD', CheckboxType::class)

            ->add('InscrType', HiddenType::class)
            ->add('ReducFamilleID', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
