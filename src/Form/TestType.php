<?php

namespace App\Form;

use App\Classes\Form\FormConst;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('choice', ChoiceType::class,[
            'choices' => [
                '--' => '--',
                'Activités Scaphandre' => FormConst::$activitesSca,
                'Activités Diverses'   => FormConst::$activitesDiv,
                'Activités Apnée'      => FormConst::$activitesApn
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
