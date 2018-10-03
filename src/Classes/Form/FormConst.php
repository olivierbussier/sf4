<?php

namespace App\Classes\Form;

class FormConst {

    /**
     * type d'inscription
     */

    public const INSCR_NORMAL   = 1;
    public const INSCR_PASSAGER = 2;

    /**
     * Civilité
     */

    public static $civilite = [
        "-"             => '',
        "Monsieur"      => "Mr.",
        "Madame"        => "Mme.",
        "Mademoiselle"  => "Mlle."
    ];

    public static $peremere = [
        "-"             => '',
        "Père"          => "Père",
        "Mère"          => "Mère",
        "Tuteur légal"  => "Tuteur"
    ];

    public static $ouinon = [
        '-'   => '',
        'Oui' => 'Oui',
        'Non' => 'Non'
    ];

    /**
     * Niveaux Scaphandre
     */

    public const N_ENFANT   = "Enfant";
    public const N_DEBUT    = "Débutant";
    public const N_N1       = "N1";
    public const N_PA2      = "PA20";
    public const N_N2       = "N2";
    public const N_PE4      = "PE40";
    public const N_PA4      = "PA40";
    public const N_N3       = "N3";
    public const N_N4       = "N4";
    public const N_N2I      = "N2I";
    public const N_N3I      = "N3I";
    public const N_N4I      = "N4I";
    public const N_MF1      = "MF1";
    public const N_MF2      = "MF2";
    public const N_OWD      = "OWD";
    public const N_AOWD     = "AOWD";
    public const N_RDMD     = "RDMD";

    public static $niveauxSca = [
        "-"                         => '',
        "Enfant"                    => self::N_ENFANT,
        "Débutant"                  => self::N_DEBUT,
        "Niveau 1"                  => self::N_N1,
        "PA20"                      => self::N_PA2,
        "Niveau 2"                  => self::N_N2,
        "PE40"                      => self::N_PE4,
        "PA40"                      => self::N_PA4,
        "Niveau 3"                  => self::N_N3,
        "Niveau 4"                  => self::N_N4,
        "Niveau 2 Initiateur (E1)"  => self::N_N2I,
        "Niveau 3 Initiateur (E1)"  => self::N_N3I,
        "Niveau 4 Initiateur (E2)"  => self::N_N4I,
        "MF1 (E3)"                  => self::N_MF1,
        "MF2 (E4)"                  => self::N_MF2,
        "Open Water Diver"          => self::N_OWD,
        "Advanced Open Water Diver" => self::N_AOWD,
        "Rescue Diver/Master Diver" => self::N_RDMD
    ];

    /**
     * Niveaux d'Apnée
     */

    public const N_A1       = "A1";
    public const N_A2       = "A2";
    public const N_A3       = "A3";
    public const N_A4       = "A4";
    public const N_A2I      = "A2I";
    public const N_A3I      = "A3I";
    public const N_A4I      = "A4I";
    public const N_MEF1     = "MEF1";
    public const N_MEF2     = "MEF2";

    public static $niveauxApn = [
        "-"                         => '',
        "Débutant"                  => self::N_DEBUT,
        "Niveau 1 (A1)"             => self::N_A1,
        "Niveau 2 (A2)"             => self::N_A2,
        "Niveau 2 Initiateur (IE1)" => self::N_A2I,
        "Niveau 3 (A3)"             => self::N_A3,
        "Niveau 3 Initiateur (IE2)" => self::N_A3I,
        "Niveau 4 (A4)"             => self::N_A4,
        "Niveau 4 Initiateur (IE2)" => self::N_A4I,
        "MEF1"                      => self::N_MEF1,
        "MEF2"                      => self::N_MEF2
    ];

    /**
     * Niveaux d'encadrement
     */

    public const NIVEAUX_ENCADRANTS  = [
        self::N_N2I,self::N_N3I,self::N_N4,self::N_N4I,self::N_MF1,self::N_MF2,
        self::N_A2I,self::N_A3I,self::N_A4I,self::N_MEF1,self::N_MEF2
    ];

    /**
     * Activités Scaphandre
     */

    public const A_ENFANTS      = "Section Enfants";
    public const A_PN1          = "Prépa N1";
    public const A_PN2          = "Prépa N2";
    public const A_PE4          = "Prépa PE40";
    public const A_PN3          = "Prépa N3";
    public const A_PN4          = "Prépa N4";
    public const A_PINITIATEUR  = "Prépa Initiateur";
    public const A_PMF1         = "Prépa MF1";

    public static $activitesSca = [
        "Section Enfants"           => self::A_ENFANTS,
        "Prépa Niveau 1 (N1)"       => self::A_PN1,
        "Prépa Niveau 2 (N2)"       => self::A_PN2,
        "Prépa PE40 (Plongeur encadré 40m)"                => self::A_PE4,
        "Prépa Niveau 3 (N3)"       => self::A_PN3,
        "Prépa Niveau 4 (N4)"       => self::A_PN4,
        "Prépa Initiateur (E1/E2)"  => self::A_PINITIATEUR,
        "Prépa MF1 (E3)"            => self::A_PMF1
    ];

    /**
     * Activités progression
     */

    public const A_PROGRESSION = [
        self::A_PN2,self::A_PE4,self::A_PN3,self::A_PN4,self::A_PINITIATEUR
    ];

    /**
     * Activités Apnée
     */

    public const A_APNEEDEB     = "Apnée Débutants";
    public const A_APNEECONF    = "Apnée Confirmés";

    public static $activitesApn = [
        "Débutants" => self::A_APNEEDEB,
        "Confirmés" => self::A_APNEECONF
    ];

    /**
     * Activités diverses
     */

    public const A_PERFPMT      = "Perf PMT";
    public const A_MAINTIEN     = "Maintien";

    public static $activitesDiv = [
        "Perfectionnement PMT"       => self::A_PERFPMT,
        "Nage non encadrée/Maintien" => self::A_MAINTIEN,
    ];

    /**
     * Activités Encadrement
     */

    public const A_ENCADREMENT  = "Encadrement";

    public static $activitesEnc = [
        "Encadrement d'une activité"                => self::A_ENCADREMENT
    ];

    /**
     * Cotisations GUC
     */

    public const COT_BENEVOLE = "Bénévole/Encadrant";
    public const COT_ENFANTS  = "Enfants/Etudiants";
    public const COT_DEBUTANT = "Débutants";
    public const COT_MAINTIEN = "Maintien";
    public const COT_PROGRESS = "Progression";
    public const COT_APNEESCA = "Apnée plongeur";
    public const COT_APNEE    = "Apnée non plongeur";

    /**
     * Licences FFESSM
     */

    public const LIC_AUTRE_CLUB = "Autre club";
    public const LIC_ENFANT = "Enfant";
    public const LIC_JUNIOR = "Junior";
    public const LIC_ADULTE = "Adulte";


    /**
     * Assurance AXA
     */

    public const A_L1B = "Loisir 1 Base";
    public const A_L2B = "Loisir 2 Base";
    public const A_L3B = "Loisir 3 Base";
    public const A_L1T = "Loisir 1 Top";
    public const A_L2T = "Loisir 2 Top";
    public const A_L3T = "Loisir 3 Top";
    public const A_PIS = "Piscine";
    public const A_NONE = "Aucune";

    public static $axaBase = [
        self::A_L1B  => 'AXA_L1B',
        self::A_L2B  => 'AXA_L2B',
        self::A_L3B  => 'AXA_L3B',
    ];
    public static $axaTop = [
        self::A_L1T  => 'AXA_L1T',
        self::A_L2T  => 'AXA_L2T',
        self::A_L3T  => 'AXA_L3T',
    ];
    public static $axaPisc = [
        self::A_PIS  => 'AXA_PIS',
        self::A_NONE => 'Aucune'
    ];

    public const FAC_NONE   = 'Aucune facture';
    public const FAC_CAESUG = 'Prise en charge CAESUG';
    public const FAC_PERSO  = 'Facture à votre nom';

    public static $facture = [
        self::FAC_NONE  => 'Non',
        self::FAC_PERSO => 'Oui',
        self::FAC_CAESUG=> 'CAESUG'
    ];
}