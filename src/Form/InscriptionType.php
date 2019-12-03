<?php

namespace App\Form;

use App\Classes\Form\FormConst;
use App\Classes\Inscription\ListesInscription;
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
            ->add('Genre', ChoiceType::class,['choices' => FormConst::CIVILITE])
            ->add('Adresse1')
            ->add('Adresse2')
            ->add('CodePostal')
            ->add('Ville')
            ->add('Profession')
            ->add('DateNaissance', DateType::class, [
                'widget' => 'single_text',
                'html5'  => false,
                'attr'   => [
                    'class' => 'js-datepicker',
                    'onchange' => 'adaptprix()'
                ]
            ])
            ->add('TelFix')
            ->add('TelPort')
            ->add('fEtudiant',CheckboxType::class, [
                'attr'   => [
                    'onchange' => 'adaptprix()'
                ]
            ])
            ->add('NiveauSca', ChoiceType::class, [
                'choices' => FormConst::NIVEAUXSCA,
                'attr'   => [
                    'onchange' => 'adaptprix()'
                ]
            ])
            ->add('NiveauApn', ChoiceType::class, [
                'choices' => FormConst::NIVEAUXAPN,
                'attr'   => [
                    'onchange' => 'adaptprix()'
                ]
            ])
            ->add('Diplomes',DiplomesType::class)
            ->add('Activite', ChoiceType::class, [
                'choices' => [
                    '--' => '--',
                    'Activités Scaphandre' => FormConst::ACTIVITESSCA,
                    'Activités Nage'       => FormConst::ACTIVITESDIV,
                    'Activités Apnée'      => FormConst::ACTIVITESAPN,
                    'Activités Encadrement'=> FormConst::ACTIVITESENC,
                ],
                'attr'   => [
                    'onchange' => 'adaptprix()'
                ]
            ])
            ->add('fApneeSca',CheckboxType::class,[
                'attr'   => [
                    'onchange' => 'adaptprix()'
                ]
            ])
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
            ->add('fAllergAspirine', ChoiceType::class, [
                'choices' => FormConst::OUINON
            ])
            ->add('fLicence', CheckboxType::class, [
                'attr'   => [
                    'onchange' => 'adaptprix()'
                ]
            ])
            ->add('Assurance', ChoiceType::class, [
                'choices' => [
                    '--'          => '',
                    'Loisir Base' => FormConst::AXABASE,
                    'Loisir Top'  => FormConst::AXATOP,
                    'Autres'     => FormConst::AXAPISC
                ],
                'attr'   => [
                    'onchange' => 'adaptprix()'
                ]
            ])
            ->add('ReducFam')
            ->add('fMailGUC', ChoiceType::class, [
                'choices' => FormConst::OUINON
            ])
            ->add('Facture', ChoiceType::class, [
                'choices' => FormConst::FACTURE,
                'attr'   => [
                    'onchange' => 'adaptprix()'
                ]
            ])
            ->add('PretMateriel', ChoiceType::class, [
                'choices' => FormConst::OUINON,
                'attr'   => [
                    'onchange' => 'adaptprix()'
                ]
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
            'data_class' => Adherent::class,
        ]);
    }
}
