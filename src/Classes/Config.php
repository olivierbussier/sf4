<?php

namespace App\Classes;

// Ce fichier contient l'ensemble des variables de configuration qui ne dépendent pas
// de l'environnement d'execution
// ----------------------------------------------------------------------------------

class Config
{
    /******************************************************************/
    // Paramétrages de base
    /******************************************************************/
    public const p_annee = 2017;  // Pour l'année scolaire 2017-2018
    public const nb_sess_req = 2;     // Nombre de sessions de gonflage obligatoires
    /******************************************************************/
    // Répertoire utilisés
    /******************************************************************/
    public const path_photo  = "../identites/";  // Photos d'identité
    public const path_certif = "../certif/";
    public const path_fiches = "../insc/";       // Fiches d'inscription PDF
    public const path_fact   = "../factures/";   // Factures
    public const path_team   = "images/team/";
    /******************************************************************/
    // Fichiers de Log
    /******************************************************************/
    private const PATH_LOGS     = __DIR__ . "/../../logs/";
    public const LOG_AP         = 1;
    public const LOG_DB         = 2;
    public const LOG_ML         = 3;

    public const filelog = [
        self::LOG_AP => self::PATH_LOGS . 'log_ap.log',
        self::LOG_DB => self::PATH_LOGS . 'log_db.log',
        self::LOG_ML => self::PATH_LOGS . 'log_ml.log'
    ];
    /******************************************************************/
    // Ouverture des inscriptions
    /******************************************************************/
    const INSCR_AUCUNE   = 0;
    const INSCR_PASSAGER = 1;
    const INSCR_NORMAL   = 3;

    // TODO a déplacer dans configenv
    //public static $status_inscriptions = self::INSCR_AUCUNE;
    //public static $status_inscriptions = self::INSCR_PASSAGER;
    public const status_inscriptions = self::INSCR_NORMAL;
    /******************************************************************/
    public const insc_enfants = true;  // false si section complete
    public const resp_enfants = array("Pierre Frouin" => "pierre.frouin@neuf.fr");
    /******************************************************************/
    public const insc_N1 = true;  // false si section complete
    public const resp_N1 = array("Xavier Dupuis" => "xdupuis@gmail.com");
    /******************************************************************/
    public const insc_N2 = true;  // false si section complete
    public const resp_N2 = array("Serge Morand" => "srg.morand@sfr.fr");
    /******************************************************************/
    public const insc_apnee = true;  // false si section complete
    public const resp_apnee = array("Thierry Lamboley" => "thlamboley@laposte.net",
                                      "Philippe Péan" => "phil.pean@gmail.com");
    /******************************************************************/
    public const NOM_CAESUG  = "Jérôme Mars";      // Nom de la personne en charge du CAESUG
    public const MAIL_CAESUG = "Jerome.Mars@gipsa-lab.grenoble-inp.fr"; // mail de la personne en charge du CAESUG pour le GUC
    /******************************************************************/
    // Liens et textes affiches dans le PDF
    /******************************************************************/
    public const P_LCERTIF      = "http://www.guc-plongee.net/docs/CertMed.pdf";
    public const P_LAXA         = "http://www.cabinet-lafont.com/accueil/Tableau_garanties_2017-2018.pdf";
    public const P_BAS          = "Vous pourrez déposer votre dossier chaque Mardi, de 19h00 à 21h00, ".
                                  "à compter du 12 Septembre à la piscine de saint martin d'Hères.";
    public const P_BAS_PASSAGER = "Vous pourrez déposer votre dossier chaque Mardi, ou les envoyer par courrier ".
                                    "à l'adresse indiquée dans le cartouche ci-dessus.";
    public const DATE_DOSSIER   = "12 Septembre 2017";
    /******************************************************************/
    // Cautions
    /******************************************************************/
    public const  CAUTION_MATOS = 500;   // Chèque de caution maétériel
    public const  BADGE_PISCINE = 6;     // Caution du badge d'accès piscine
    /******************************************************************/
    //Fede
    /******************************************************************/
    public const  LICENCE_12   = 12;    // Licence moins de 12 ans (a partir de 10)
    public const  LICENCE12_16 = 26;    // Licence de 12 ans à 16 ans
    public const  LICENCE_ADUL = 40;    // Licence Adulte
    /******************************************************************/
    // AXA
    /******************************************************************/
    public const  AXA_L1B = 20.00; // Loisir 1 Base
    public const  AXA_L2B = 25.00; // Loisir 2 Base
    public const  AXA_L3B = 42.00; // Loisir 3 Base
    public const  AXA_L1T = 39.00; // Loisir 1 Top
    public const  AXA_L2T = 50.00; // Loisir 2 Top
    public const  AXA_L3T = 83.00; // Loisir 3 Top
    public const  AXA_PIS = 11.00; // Piscine
    /******************************************************************/
    // Club
    /******************************************************************/
    public const  CLUB_BENE = 50;  // Bénévole
    public const  CLUB_JEUN = 100; // Enfants/Etudiants
    public const  CLUB_MAIN = 100; // Maintien
    public const  CLUB_AUTR = 140; // Progression
    public const  CLUB_DEBU = 100; // Débutants
    public const  CLUB_APN1 = 100; // Nage Avec Palmes/Apnée et Plongeur Tarif 1
    public const  CLUB_APN2 = 50;  // Nage Avec Palmes/Apnée non Plongeur Tarif 2
    public const  CARTE_GUC = 5;   // Prix de la carte GUC
    /******************************************************************/
    // Divers
    /******************************************************************/
    public const  SIUAPS          = 22;
    public const  REDUC_FAMILLE   = 50;  // Réduction pour plusieurs membres famille
    public const  MAJO_COTISATION = 15;  // Si dossier en retard
    public const  TAXE            = 0; // Taux de taxe applicable pour les factures
    /******************************************************************/
}
