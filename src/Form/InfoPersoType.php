<?php

namespace App\Form;

use App\Entity\Adherent;
use Doctrine\DBAL\Types\StringType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                    'Admin' => 'ROLE_ADMIN',
                    'User'  => 'ROLE_USER',
                    'Toto'  => 'ROLE_TOTO'
                ],
                'expanded' => false,
                'multiple' => true
            ])
            ->add('ListeDroits',ChoiceType::class, [
                'choices' => [
                ],
                'expanded' => false,
                'multiple' => true
            ])
            ->add('CodeSecret')
            ->add('Password')
            ->add('Genre')
            ->add('Adresse1')
            ->add('Adresse2')
            ->add('CodePostal')
            ->add('Ville')
            ->add('Profession')
            ->add('DateNaissance')
            ->add('LieuNaissance')
            ->add('DepartementNaissance')
            ->add('TelFix')
            ->add('TelPort')
            ->add('fEtudiant')
            ->add('NiveauSca')
            ->add('NiveauApn')
            ->add('Diplomes',ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'Super' => 'ROLE_SUPER_ADMIN'
                ],
                'expanded' => false,
                'multiple' => true
            ])
            ->add('fApneeSca')
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
