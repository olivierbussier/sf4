<?php

namespace App\Classes\Config;

// Ce fichier contient l'ensemble des variables de configuration qui ne dépendent pas
// de l'environnement d'execution
// ----------------------------------------------------------------------------------

class Config
{
    /******************************************************************/
    // Paramétrages de base
    /******************************************************************/
    public static $p_annee = 2018;  // Pour l'année scolaire 2017-2018
    public static $nb_sess_req = 2;     // Nombre de sessions de gonflage obligatoires
    /******************************************************************/
    // Répertoire utilisés
    /******************************************************************/
    public static $path_photo  = "../identites/";  // Photos d'identité
    public static $path_certif = "../certif/";
    public static $path_diplome= "../diplomes/";
    public static $path_fiches = "../insc/";       // Fiches d'inscription PDF
    public static $path_fact   = "../factures/";   // Factures
    public static $path_team   = "images/team/";
    /******************************************************************/
    // Fichiers de Log
    /******************************************************************/
    private const PATH_LOGS     = __DIR__ . "/../../logs/";
    public const LOG_AP         = 1;
    public const LOG_DB         = 2;
    public const LOG_ML         = 3;

    static public $filelog = [
        self::LOG_AP => self::PATH_LOGS . 'log_ap.log',
        self::LOG_DB => self::PATH_LOGS . 'log_db.log',
        self::LOG_ML => self::PATH_LOGS . 'log_ml.log'
    ];

    /******************************************************************/
    public const  insc_enfants = true;  // false si section complete
    public const  resp_enfants = array("Pierre Frouin" => "pierre.frouin@neuf.fr");
    /******************************************************************/
    public const  insc_N1 = true;  // false si section complete
    public const  resp_N1 = array("Xavier Dupuis" => "xdupuis@gmail.com");
    /******************************************************************/
    public const  insc_N2 = true;  // false si section complete
    public const  resp_N2 = array("Serge Morand" => "srg.morand@sfr.fr");
    /******************************************************************/
    public const  insc_apnee = true;  // false si section complete
    public const  resp_apnee = array("Thierry Lamboley" => "thlamboley@laposte.net",
                                      "Philippe Péan" => "phil.pean@gmail.com");
    /******************************************************************/
    public const NOM_CAESUG  = "Jérôme Mars";      // Nom de la personne en charge du CAESUG
    public const MAIL_CAESUG = "Jerome.Mars@gipsa-lab.grenoble-inp.fr"; // mail de la personne du CAESUG pour le GUC
    /******************************************************************/
    // Liens et textes affiches dans le PDF
    /******************************************************************/
    public const P_LCERTIF      = "http://www.guc-plongee.net/docs/CertMed.pdf";
    public const P_LAXA         = "https://ffessm.fr/ckfinder/userfiles/files/pdf/saison-2018-2019/Fiche-AIA_Licencie-FFESSM_LafontAssurances-2018-2019.pdf";
    public const P_BAS          = "Vous pourrez déposer votre dossier chaque Mardi, de 19h00 à 21h00, ".
                                  "à compter du 18 Septembre à la piscine de saint martin d'Hères.";
    public const P_BAS_PASSAGER = "Vous pourrez déposer votre dossier chaque Mardi, ou les envoyer par courrier ".
                                    "à l'adresse indiquée dans le cartouche ci-dessus.";
    public const DATE_DOSSIER   = "18 Septembre 2018";
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
    public const  AXA_NON =  0.00; // Aucune
    /******************************************************************/
    // Divers
    /******************************************************************/
    public const  SIUAPS          = 22;
    public const  SIUAPS_NEW      = 0;
    public const  REDUC_FAMILLE   = 50;  // Réduction pour plusieurs membres famille
    public const  MAJO_COTISATION = 15;  // Si dossier en retard
    public const  TAXE            = 0; // Taux de taxe applicable pour les factures
    /******************************************************************/
    // Club
    /******************************************************************/
    public const  CLUB_BENE = 50 +self::SIUAPS_NEW; // Bénévole
    public const  CLUB_JEUN = 100+self::SIUAPS_NEW; // Enfants/Etudiants
    public const  CLUB_MAIN = 100+self::SIUAPS_NEW; // Maintien
    public const  CLUB_AUTR = 140+self::SIUAPS_NEW; // Progression
    public const  CLUB_DEBU = 100+self::SIUAPS_NEW; // Débutants
    public const  CLUB_APN1 = 100+self::SIUAPS_NEW; // Nage Avec Palmes/Apnée et Plongeur Tarif 1
    public const  CLUB_APN2 = 50 +self::SIUAPS_NEW; // Nage Avec Palmes/Apnée non Plongeur Tarif 2
    public const  CARTE_GUC = 5;   // Prix de la carte GUC}
    //******************************************************************/
    // Payment
    //******************************************************************/
    public const payment_paypal = false;
}