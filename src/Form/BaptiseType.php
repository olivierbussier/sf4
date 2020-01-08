<?php

namespace App\Form;

use App\Entity\Baptise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BaptiseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Sexe', ChoiceType::class, [
                'label' => 'Sexe'
            ])
            ->add('Nom', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('Prenom', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('Age', ChoiceType::class, [
                'label' => 'Age'
            ])
            ->add('Taille', ChoiceType::class, [
                'label' => 'Taille'
            ])
            ->add('Pointure', ChoiceType::class, [
                'label' => 'Pointure'
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
