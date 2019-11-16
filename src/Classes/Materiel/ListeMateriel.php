<?php

namespace App\Classes\Materiel;

class ListeMateriel
{

    const SELOPTIONS = [
        ["status" => "service"    , "text" => 'En service'],
        ["status" => "reforme"    , "text" => 'Réformé'],
        ["status" => "maintenance", "text" => 'Maintenance']
    ];

    const SELSORTIES = [
        "-"           => "-"                       ,
        "explolac"    => "Sortie GUC explo Lac"    ,
        "exploguc"    => "Sortie GUC explo Mer"    ,
        "techniolon"  => "Sortie technique Niolon" ,
        "techlac"     => "Sortie technique Lac"    ,
        "techCTD"     => "Sortie technique CTD"    ,
        "clubexterne" => "Sortie Autre club"       ,
        "Horsstruct"  => "Sortie Hors structure"
    ];

}

