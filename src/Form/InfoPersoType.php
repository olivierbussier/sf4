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
            ->add('Username', null,['disabled' => true])
            ->add('Nom', null,['disabled' => true])
            ->add('Prenom', null,['disabled' => true])
            ->add('Mail')
            ->add('Roles',ChoiceType::class, [
                'choices' => [
                    'ROLE_PN1'         => 'ROLE_PN1',
                    'ROLE_PN2'         => 'ROLE_PN2',
                    'ROLE_PN3'         => 'ROLE_PN3',
                    'ROLE_PN4'         => 'ROLE_PN4',
                    'ROLE_PMF1'        => 'ROLE_PMF1',
                    'ROLE_PINI'        => 'ROLE_PINI',
                    'ROLE_ENFANT'      => 'ROLE_ENFANT',
                    'ROLE_ADO'         => 'ROLE_ADO',
                    'ROLE_PMT'         => 'ROLE_PMT',
                    'ROLE_APNEE'       => 'ROLE_APNEE',
                    'ROLE_BAPTEME'     => 'ROLE_BAPTEME',
                    'ROLE_CRT'         => 'ROLE_CRT',
                    'ROLE_ADMIN'       => 'ROLE_ADMIN',
                    'ROLE_GON'         => 'ROLE_GON',
                    'ROLE_MAT'         => 'ROLE_MAT',
                    'ROLE_PUB'         => 'ROLE_PUB',
                    'ROLE_BUREAU'      => 'ROLE_BUREAU'
                ],
                'expanded' => false,
                'multiple' => true,
                'disabled' => true
            ])
            /*->add('ListeDroits',ChoiceType::class, [
                'choices' => [
                ],
                'expanded' => false,
                'multiple' => true,
                'disabled' => true
            ])*/
            //->add('CodeSecret')
            //->add('Password')
            ->add('Genre',null, ['disabled' => true])
            ->add('Adresse1')
            ->add('Adresse2')
            ->add('CodePostal')
            ->add('Ville')
            ->add('Profession')
            ->add('DateNaissance', DateType::class, [
                'widget' => 'single_text',
                'html5'  => true,
                'disabled' => true
                //'attr'   => ['class' => 'js-datepicker']
            ])
            ->add('LieuNaissance')
            ->add('DepartementNaissance')
            ->add('TelFix')
            ->add('TelPort')
            ->add('fEtudiant')
            ->add('NiveauSca')
            ->add('NiveauApn')/*
            ->add('Diplomes',ChoiceType::class, [
                'choices' => [
                    'TIV' => 'TIV',
                    'Formateur TIV' => 'FTIV'
                ],
                'expanded' => false,
                'multiple' => true,
                'disabled' => true
            ])*/
            ->add('fApneeSca',ChoiceType::class, [
                'choices' => [
                    'Apnéiste Plongeur' => true,
                    'Apnéiste non plongeur' => false
                ],
                'expanded' => false,
                'multiple' => false,
                'disabled' => true
            ])
            ->add('Activite')
            ->add('fBenevole')
            ->add('fEncadrant')
            ->add('AccidentNom')
            ->add('AccidentPrenom')
            ->add('AccidentTelFix')
            ->add('AccidentTelPort')
            ->add('DateCertif')
            ->add('fAllergAspirine')
            ->add('Licence')
            ->add('Cotisation')
            ->add('fCarteGUC')
            ->add('fCarteSIUAPS')
            ->add('fMailGUC')
            ->add('fTrombi')
            ->add('EnvoiGUC')
            ->add('EnvoiSIUAPS')
            ->add('Facture')
            ->add('RefFacture')
            ->add('Assurance')
            ->add('PretMateriel')
            ->add('PretMaterielOld')
            ->add('MineurNom')
            ->add('MineurPrenom')
            ->add('MineurQualite')
            ->add('ModifUser')
            ->add('DateModifUser')
            ->add('DatePremInscr')
            ->add('AdminOK',ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'Super' => 'ROLE_SUPER_ADMIN'
                ],
                'expanded' => false,
                'multiple' => true
            ])
            ->add('Comments')
            ->add('ReducFamilleID')
            ->add('ReducFam')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adherent::class,
        ]);
    }
}
