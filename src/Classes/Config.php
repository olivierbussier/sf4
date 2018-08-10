<?php

namespace App\Classes;

// Ce fichier contient l'ensemble des variables de configuration qui ne dépendent pas
// de l'environnement d'execution
// ----------------------------------------------------------------------------------

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class Config extends Controller
{
    // Recherche d'une variable dans services.yaml

    public static function getPar(string $parameter, Controller $context)
    {
        $tab = $context->getParameter('config');
        return $tab[$parameter];
    }
}
