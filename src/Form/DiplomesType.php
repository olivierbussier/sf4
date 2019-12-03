<?php

namespace App\Form;

use App\Classes\Form\FormConst;
use App\Entity\Adherent;
use App\Entity\Diplome;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiplomesType extends AbstractType {

    /*
     * @param FormBuilderInterface $builder
     * @param array $options
     *
    /*public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$builder->add('Diplomes', ChoiceType::class);
    }*/

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label' => 'Diplômes et qualifications',
            'expanded' => false,
            'multiple' => true,
            'choices' => FormConst::LISTE_DIPLOMES,
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
