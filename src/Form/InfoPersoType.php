<?php

namespace App\Form;

use App\Classes\Form\FormConst;
use App\Entity\User;
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
            ->add('Roles',RolesType::class, ['disabled' => true])
            ->add('Genre',            null, ['disabled' => true])
            ->add('Adresse1',         null)
            ->add('Adresse2',         null)
            ->add('CodePostal',       null)
            ->add('Ville')
            ->add('Profession')
            ->add('DateNaissance', DateType::class, [
                'widget'    => 'single_text',
                'html5'     => true,
                'disabled'  => true
            ])
            ->add('LieuNaissance')
            ->add('DepartementNaissance')
            ->add('TelFix')
            ->add('TelPort')
            ->add('fEtudiant', ChoiceType::class, [
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ],
                'expanded' => true,
                'multiple' => false,
                'disabled' => true
            ])
            ->add('NiveauSca',      null, [
                'disabled' => true
            ])
            ->add('NiveauApn',      null, [
                'disabled' => true
            ])
            ->add('Diplomes', DiplomesType::class, [
                'disabled' => true
            ])
            ->add('fApneeSca',ChoiceType::class, [
                'choices' => [
                    'Plongeur' => true,
                    'Non plongeur' => false
                ],
                'expanded' => true,
                'multiple' => false,
                'disabled' => true
            ])
            ->add('Activite',       null, ['disabled' => true])
            ->add('fBenevole')
            ->add('fEncadrant')
            ->add('AccidentNom')
            ->add('AccidentPrenom')
            ->add('AccidentTelFix')
            ->add('AccidentTelPort')
            ->add('DateCertif', DateType::class, [
                'widget'    => 'single_text',
                'html5'     => true,
                'disabled'  => true
            ])
            ->add('fAllergAspirine',ChoiceType::class, [
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ],
                'expanded' => false,
                'multiple' => false,
                'disabled' => true
            ])
            ->add('MineurNom',          null, [
                'disabled' => true
            ])
            ->add('MineurPrenom',       null, [
                'disabled' => true
            ])
            ->add('MineurQualite',      null, [
                'disabled' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
