<?php

namespace App\Classes\Form;

class FormConst {

    /**
     * type d'inscription
     */

    public const INSCR_NORMAL   = 1;
    public const INSCR_PASSAGER = 2;
    public const REGISTER       = 3;

    /**
     * Civilité
     */

    public const CIVILITE = [
        "-"             => '',
        "Monsieur"      => "Mr.",
        "Madame"        => "Mme.",
        "Mademoiselle"  => "Mlle."
    ];

    public const PEREMERE = [
        "-"             => '',
        "Père"          => "Père",
        "Mère"          => "Mère",
        "Tuteur légal"  => "Tuteur"
    ];

    public const OUINON = [
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

    public const NIVEAUXSCA = [
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

    public const NIVEAUXAPN = [
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

    public const ACTIVITESSCA = [
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

    public const ACTIVITESAPN = [
        "Débutants" => self::A_APNEEDEB,
        "Confirmés" => self::A_APNEECONF
    ];

    /**
     * Activités diverses
     */

    public const A_PERFPMT      = "Perf PMT";
    public const A_MAINTIEN     = "Maintien";

    public const ACTIVITESDIV = [
        "Perfectionnement PMT"       => self::A_PERFPMT,
        "Nage non encadrée/Maintien" => self::A_MAINTIEN,
    ];

    /**
     * Activités Encadrement
     */

    public const A_ENCADREMENT  = "Encadrement";

    public const ACTIVITESENC = [
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

    public const AXABASE = [
        self::A_L1B  => self::A_L1B,
        self::A_L2B  => self::A_L2B,
        self::A_L3B  => self::A_L3B,
    ];
    public const AXATOP = [
        self::A_L1T  => self::A_L1T,
        self::A_L2T  => self::A_L2T,
        self::A_L3T  => self::A_L3T,
    ];
    public const AXAPISC = [
        self::A_PIS  => 'AXA_PIS',
        self::A_NONE => 'Aucune'
    ];

    public const FACTURE = [
        'Aucune facture'         => 'Non',
        'Prise en charge CAESUG' => 'Oui',
        'Facture à votre nom'    => 'CAESUG'
    ];

    public const LISTE_DIPLOMES = [
        'Matériel' => [
            'TIV'               => 'TIV',
            'Formateur TIV'     => 'FTIV'
        ],
        'Médical' => [
            'Médecin'           => 'MED',
            'Médecin Fédéral'   => 'MEDF',
            'PSE1/PSE2/Anteor'  => 'SEC',
        ],
        'Plongée tek' => [
            'Nitrox'            => 'NITR',
            'Nitrox Confirmé'   => 'NIRTC',
            'Trimix Normoxique' =>'TRIN',
            'Trimix Hypoxique'  => 'TRIH'
        ]
    ];

    public const LISTE_ROLES_ENC = [
        'Encadrant'            => 'ROLE_ENC',
        'Encadrant N1'         => 'ROLE_PN1',
        'Encadrant N2'         => 'ROLE_PN2',
        'Encadrant N3'         => 'ROLE_PN3',
        'Encadrant N4'         => 'ROLE_PN4',
        'Encadrant MF1'        => 'ROLE_PMF1',
        'Encadrant Initiateur' => 'ROLE_PINI',
        'Encadrant Enfant'     => 'ROLE_ENFANT',
        'Encadrant Ado'        => 'ROLE_ADO',
        'Encadrant PMT'        => 'ROLE_PMT',
        'Encadrant Apnée'      => 'ROLE_APNEE',
        'Encadrant Baptême'    => 'ROLE_BAPTEME',
    ];
    public const LISTE_ROLES_ADM = [
        'Alerte Certif'        => 'ROLE_CRT',
        'Administrateur'       => 'ROLE_ADMIN',
        'Gonflage'             => 'ROLE_GON',
        'Matériel'             => 'ROLE_MAT',
        'Aide Matériel'        => 'ROLE_AMAT',
        'Publication'          => 'ROLE_PUB',
        'Inscriptions'         => 'ROLE_INSC',
        'Bureau'               => 'ROLE_BUREAU'
    ];

    public const ABBREV_ROLES = [
        'Encadrant'            => 'ENC',
        'Encadrant N1'         => 'PN1',
        'Encadrant N2'         => 'PN2',
        'Encadrant N3'         => 'PN3',
        'Encadrant N4'         => 'PN4',
        'Encadrant MF1'        => 'PMF1',
        'Encadrant Initiateur' => 'PINI',
        'Encadrant Enfant'     => 'ENF',
        'Encadrant Ado'        => 'ADO',
        'Encadrant PMT'        => 'PMT',
        'Encadrant Apnée'      => 'APN',
        'Encadrant Baptême'    => 'BAP',
        'Alerte Certif'        => 'CRT',
        'Administrateur'       => 'ADMIN',
        'Gonflage'             => 'GON',
        'Matériel'             => 'MAT',
        'Aide Matériel'        => 'AMAT',
        'Publication'          => 'PUB',
        'Inscriptions'         => 'INSC',
        'Bureau'               => 'BUR'
    ];

    public const LISTE_ROLES = self::LISTE_ROLES_ENC + self::LISTE_ROLES_ADM;

}
