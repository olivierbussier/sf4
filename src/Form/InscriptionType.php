<?php

namespace App\Form;

use App\Classes\Form\FormConst;
use App\Entity\Adherent;
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
            ->add('Genre', ChoiceType::class,['choices' => FormConst::$civilite])
            ->add('Adresse1')
            ->add('Adresse2')
            ->add('CodePostal')
            ->add('Ville')
            ->add('Profession')
            ->add('DateNaissance', DateType::class, [
                'widget' => 'single_text',
                'html5'  => false,
                'attr'   => [ 'class' => 'js-datepicker']
            ])
            ->add('TelFix')
            ->add('TelPort')
            ->add('fEtudiant')
            ->add('NiveauSca', ChoiceType::class, ['choices' => FormConst::$niveauxSca])
            ->add('NiveauApn', ChoiceType::class, ['choices' => FormConst::$niveauxApn])
            //->add('diplomes')
            ->add('Activite', ChoiceType::class, [
                'choices' => [
                    '--' => '--',
                    'Activités Scaphandre' => FormConst::$activitesSca,
                    'Activités Nage'       => FormConst::$activitesDiv,
                    'Activités Apnée'      => FormConst::$activitesApn,
                    'Activités Encadrement'=> FormConst::$activitesEnc,
                ],
                'attr'   => [
                    'onchange' => 'adaptprix()'
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
                'html5'  => false,
                'attr'   => [ 'class' => 'js-datepicker']
            ])
            ->add('fAllergAspirine')
            ->add('Licence')
            ->add('Assurance', ChoiceType::class, [
                'choices' => [
                    '--'          => '--',
                    'Loisir Base' => FormConst::$axaBase,
                    'Loisir Top'  => FormConst::$axaTop,
                    'Autres'     => FormConst::$axaPisc
                ]
            ])
            ->add('ReducFam')
            ->add('fMailGUC', ChoiceType::class, [
                'choices' => FormConst::$ouinon
            ])
            ->add('Facture', ChoiceType::class, [
                'choices' => FormConst::$facture
            ])
            ->add('PretMateriel', ChoiceType::class, [
                'choices' => FormConst::$ouinon
            ])
            ->add('MineurNom')
            ->add('MineurPrenom')
            ->add('MineurQualite', ChoiceType::class, [
                'choices' => FormConst::$peremere
            ])
            ->add('MineurSign', CheckboxType::class)
            ->add('ReglementRGPD', CheckboxType::class)

            ->add('InscrType', HiddenType::class)
            ->add('ReducFamilleID', HiddenType::class)

            //->add('LieuNaissance')
            //->add('DepartementNaissance')
            //->add('fTrombi')
            //->add('Cotisation')
            //->add('EnvoiGUC')
            //->add('EnvoiSIUAPS')
            //->add('fCarteGUC')
            //->add('fCarteSIUAPS')
            //->add('RefFacture')
            //->add('ReducFamilleID')
            //->add('Username')
            //->add('Nom')
            //->add('Prenom')
            //->add('ListeDroits')
            //->add('CodeSecret')
            //->add('Password')
            //->add('fEncadrant')
            //->add('PretMaterielOld')
            //->add('DateModifUser')
            //->add('DatePremInscr')
            //->add('AdminOK')
            //->add('Comments')
            //->add('ModifUser')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adherent::class,
        ]);
    }
}
