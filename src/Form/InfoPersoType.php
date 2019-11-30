<?php

namespace App\Form;

use App\Entity\Adherent;
use Doctrine\DBAL\Types\StringType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class InfoPersoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('Username',   null,['disabled' => true])
            ->add('Nom',        null,['disabled' => true])
            ->add('Prenom',     null,['disabled' => true])
            ->add('Mail')
            ->add('Roles',ChoiceType::class, [
                'choices' => [
                    'Encadrant N1'         => 'ROLE_PN1',
                    'Encadrant N2'         => 'ROLE_PN2',
                    'Encadrant N3'         => 'ROLE_PN3',
                    'Encadrant N4'         => 'ROLE_PN4',
                    'Encadrant MF1'        => 'ROLE_PMF1',
                    'Encadrant Initiateur' => 'ROLE_PINI',
                    'Encadrant Enfant'     => 'ROLE_ENFANT',
                    'Encadrant Ado'        => 'ROLE_ADO',
                    'Encadrant PMT'        => 'ROLE_PMT',
                    'Encadrant Apnée'      => 'ROLE_APNEE',
                    'Encadrant Baptême'    => 'ROLE_BAPTEME',
                    'Alerte Certif'        => 'ROLE_CRT',
                    'Administrateur'       => 'ROLE_ADMIN',
                    'Gonflage'             => 'ROLE_GON',
                    'Matériel'             => 'ROLE_MAT',
                    'Publication'          => 'ROLE_PUB',
                    'Bureau'               => 'ROLE_BUREAU'
                ],
                'expanded' => false,
                'multiple' => true,
                'disabled' => true
            ])
            ->add('Genre',      null, ['disabled' => true])
            ->add('Adresse1',      null, ['label' => 'Adresse'])
            ->add('Adresse2',      null, ['label' => 'Suite adresse'])
            ->add('CodePostal',      null, ['label' => 'Code Postal'])
            ->add('Ville')
            ->add('Profession')
            ->add('DateNaissance', DateType::class, [
                'widget'    => 'single_text',
                'html5'     => true,
                'disabled'  => true,
                'label' => 'Date de naissance'
                //'attr'   => ['class' => 'js-datepicker']
            ])
            ->add('LieuNaissance')
            ->add('DepartementNaissance')
            ->add('TelFix')
            ->add('TelPort')
            ->add('fEtudiant',ChoiceType::class, [
                'label' => 'Etudiant',
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ],
                'expanded' => false,
                'multiple' => false,
                'disabled' => true
            ])
            ->add('NiveauSca',      null, [
                'label' => 'Niveau Scaphandre',
                'disabled' => true
            ])
            ->add('NiveauApn',      null, [
                'label' => 'Niveau Apnée',
                'disabled' => true
            ])

            ->add('Diplomes',ChoiceType::class, [
                'label' => 'Diplômes et qualifications',
                'choices' => [
                    'TIV' => 'TIV',
                    'Formateur TIV' => 'FTIV',
                    'Médecin' => 'MED',
                    'Médecin Fédéral' => 'MEDF',
                    'Nitrox' => 'NITR',
                    'Nitrox Confirmé' => 'NIRTC',
                    'Trimix Normoxique' =>'TRIN',
                    'Trimix Hypoxique' => 'TRIH',
                ],
                'expanded' => false,
                'multiple' => true,
                'disabled' => true
            ])
            ->add('fApneeSca',ChoiceType::class, [
                'label' => 'Apnéiste ou maintien Plongeur',
                'choices' => [
                    'Plongeur' => true,
                    'Non plongeur' => false
                ],
                'expanded' => false,
                'multiple' => false,
                'disabled' => true
            ])
            ->add('Activite',       null, ['disabled' => true])
            ->add('fBenevole')
            ->add('fEncadrant')
            ->add('AccidentNom', null, ['label' => 'Nom du contact en cas d\'accident'])
            ->add('AccidentPrenom', null, ['label' => 'Prénom du contact en cas d\'accident'])
            ->add('AccidentTelFix', null, ['label' => 'Téléphone fixe du contact en cas d\'accident'])
            ->add('AccidentTelPort', null, ['label' => 'Téléphone GSM du contact en cas d\'accident'])
            ->add('DateCertif', DateType::class, [
                'label'     => 'Date du certificat médical',
                'widget'    => 'single_text',
                'html5'     => true,
                'disabled'  => true
                //'attr'   => ['class' => 'js-datepicker']
            ])
            ->add('fAllergAspirine',ChoiceType::class, [
                'label'   => 'Allergie à l\'aspirine',
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ],
                'expanded' => false,
                'multiple' => false,
                'disabled' => true
            ])
            ->add('MineurNom',          null, [
                'label' => 'Nom du représentant légal',
                'disabled' => true
            ])
            ->add('MineurPrenom',       null, [
                'label' => 'Prénom du représentant légal',
                'disabled' => true
            ])
            ->add('MineurQualite',      null, [
                'label' => 'Qualité du représentant légal',
                'disabled' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adherent::class,
        ]);
    }
}
