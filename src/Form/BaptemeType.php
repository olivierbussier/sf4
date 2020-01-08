<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BaptemeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email de contact'
            ])
            ->add('date', ChoiceType::class, [
                'label' => 'Date souhaitée'
            ])
        ;

        $builder
            ->add('Baptise', CollectionType::class, [
                'entry_type' => BaptiseType::class,
                'entry_options' => ['label' => false],
            ])
            ->add('Envoyer', SubmitType::class, [
                'label' => 'Soumettre',
                'attr'  => ['class' => 'btn-block btn-primary']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
