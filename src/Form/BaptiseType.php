<?php

namespace App\Form;

use App\Entity\Baptise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BaptiseType extends AbstractType
{
    private const SEXE   = [
        "--"       => "--",
        "Masculin" => "Masculin",
        "Féminin"  => "Féminin"
    ];
    private const AGE    = [
        "--"             => "--",
        "8-9 ans"        => "8-9 ans",
        "10-13 ans"      => "10-13 ans",
        "14-17 ans"      => "14-17 ans",
        "18 ans et plus" => "18 ans et plus"
    ];
    private const POINT  = [
        "--" => "--",
        30 => 30,
        31 => 31,
        32 => 32,
        33 => 33,
        34 => 34,
        35 => 35,
        36 => 36,
        37 => 37,
        38 => 38,
        39 => 39,
        40 => 40,
        41 => 41,
        42 => 42,
        43 => 43,
        44 => 44,
        45 => 45,
        46 => 46,
        47 => 47,
        48 => 48
    ];
    private const TAILLE = [
        "--"  => "--",
        "XXS" => "XXS",
        "XS"  => "XS",
        "S"   => "S",
        "M"   => "M",
        "L"   => "L",
        "XL"  => "XL",
        "XXL" => "XXL"
    ];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Sexe', ChoiceType::class, [
                'label' => 'Sexe',
                'choices' => self::SEXE
            ])
            ->add('Nom', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('Prenom', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('Age', ChoiceType::class, [
                'label' => 'Age',
                'choices' => self::AGE
            ])
            ->add('Taille', ChoiceType::class, [
                'label' => 'Taille',
                'choices' => self::TAILLE
            ])
            ->add('Pointure', ChoiceType::class, [
                'label' => 'Pointure',
                'choices' => self::POINT
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Baptise::class
        ]);
    }
}
