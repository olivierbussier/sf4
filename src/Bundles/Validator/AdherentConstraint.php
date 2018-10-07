<?php

namespace App\Bundles\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */

class AdherentConstraint extends Constraint
{
    public $message = "Vous avez déjà posté un message il y a moins de 15 secondes, merci d'attendre un peu.";

    public function validatedBy()
    {
        return 'App\\Bundles\\Validator\\AdherentClassValidator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}