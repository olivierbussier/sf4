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
                'choices' => FormConst::$niveauxSca,
                'attr'   => [
                    'onchange' => 'adaptprix()'
                ]
            ])
            ->add('NiveauApn', ChoiceType::class, [
                'choices' => FormConst::$niveauxApn,
                'attr'   => [
                    'onchange' => 'adaptprix()'
                ]
            ])
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
                'choices' => FormConst::$ouinon
            ])
            ->add('fLicence', CheckboxType::class, [
                'attr'   => [
                    'onchange' => 'adaptprix()'
                ]
            ])
            ->add('Assurance', ChoiceType::class, [
                'choices' => [
                    '--'          => '',
                    'Loisir Base' => FormConst::$axaBase,
                    'Loisir Top'  => FormConst::$axaTop,
                    'Autres'     => FormConst::$axaPisc
                ],
                'attr'   => [
                    'onchange' => 'adaptprix()'
                ]
            ])
            ->add('ReducFam')
            ->add('fMailGUC', ChoiceType::class, [
                'choices' => FormConst::$ouinon
            ])
            ->add('Facture', ChoiceType::class, [
                'choices' => FormConst::$facture,
                'attr'   => [
                    'onchange' => 'adaptprix()'
                ]
            ])
            ->add('PretMateriel', ChoiceType::class, [
                'choices' => FormConst::$ouinon,
                'attr'   => [
                    'onchange' => 'adaptprix()'
                ]
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adherent::class,
        ]);
    }
}
