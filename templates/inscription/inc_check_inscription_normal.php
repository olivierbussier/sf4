<?php

namespace App\Inscription;

use App\Incl\Classes\Error;
use App\Incl\Classes\Form;
use App\Incl\Classes\Globals;
use App\Incl\Classes\PhotoHelpers;
use App\Incl\Classes\Session;

use App\Incl\Multifield\Adminok;
use App\Incl\Multifield\Diplomes;

use App\Incl\Log\LogAppli;

include_once __DIR__ . '/../bootstrap.php';

LogAppli::logAppli(LogAppli::LOGOK, "Check inscription");

if (!Session::isOpen()) {
    //db_log_message("+ERR : fonction check_inscription.php - NOM et/ou PRENOM non initialisés");
    echo "erreur 84091\n";
    exit;
}

$fDip = new Diplomes();
$diplomes_fields = $fDip->getTable();

foreach ($diplomes_fields as $key => $value) {
    if (isset($_POST[$key])) {
        $fDip->set($key, 'OUI');
    } else {
        $fDip->set($key, 'NON');
    }
}

Form::set('DIPLOMES', $fDip->getString());

// Appel des différentes fonctions de check

/** @var Error $e */

ExecAffCheck::execCheck(ExecAffCheck::NORMAL, $e);

$db = Globals::getDb();

// Calcul Licence

$l = new Calculate();

/** @var Error $e Créée par le script appelant */

$cotis = $l->calcCotis($_POST);
$axa   = $l->calcAxa(Form::get('ASSURANCE'));

// Calcul Cotisation

if ($cotis['fErr']) {
    $e->error(6, 1, "Erreur, calcul licence  impossible, revérifiez votre saisie");
} else {
    Form::set('LICENCE', $cotis['typeLicence']);
    Form::set('COTISATION', $cotis['typeCotis']);
}


// ************************************************************************************
// Fin des vérifs, pas d'erreur bloquante détectée
// ************************************************************************************
if ($e->getNbErrors() == 0) {

    $date = date("Y-m-d");

    // Toute les informations sont correctes
    // On va transférer la ligne de la table 'liste_temp' vers 'liste'
    // 2 cas de figure: l'adhérents existe , ou n'existe pas
    // -------------------------------------------------------------------

    // ------------------------------------------------------------------------
    // REFUSR pointe sur la ligne de l'adhérent de la table 'liste' (ou vaut 0 si ligne
    // inexistante)
    // REFTMP pointe sur la ligne de l'adhérent de la table 'liste_temp'
    // ------------------------------------------------------------------------

    $SQL = Form::getSQL(true);

    $REFUSR = Session::get('REFUSR');
    $REFTMP = Session::get('REFTMP');
    $MODIFUSER = Session::get('MODIFUSER');
    $NOM = Session::get('NOM');
    $PRENOM = Session::get('PRENOM');
    $PASSWD = Session::get('PASSWD');

    if ($REFUSR != 0) {
        // L'adhérent est dans la base avec cette REFUSR
        // On recopie les données du formulaire validé vers
        // la ligne existante de 'liste'
        // ------------------------------------------------------------------------------------

        $db->query("update @#@liste set " . $SQL . "," .
            "ADMINOK       = 'NON'," .
            "MODIFUSER     = '" . $MODIFUSER . "'," .
            "DATEMODIFUSER = '" . $date . "'" .
            " where Ref = '" . $REFUSR . "'");

        // Init de NEWREF pour pouvoir repositionner la variable de session REFUSR
        // à la fin de ces traitements
        // ------------------------------------------------------------------------------------
    } else {
        // L'adhérent n'est pas dans la base avec cette REFUSR
        // Cela veut dire que l'adhérent est à créer
        // On recopie les données du formulaire validé vers une
        // nouvelle ligne dans 'liste'
        // ------------------------------------------------------------------------------------

        $sq = "insert into @#@liste set " . $SQL . "," .
            "NOM    ='" . $NOM . "'," .
            "PRENOM ='" . $PRENOM . "'," .
            "PASSWD ='" . $PASSWD . "'," .
            "ADMINOK='NON'," .
            "MODIFUSER = 'NEW'," .
            "DATEMODIFUSER = '" . $date . "'," .
            "DATEPREMINSCR = '" . $date . "'";
        $db->query($sq);

        // Récuperation de la REFUSR créée

        $REFUSR = $db->last_insert_id();

        // Renommer l'image
        // Gestion du nom de fichier IMAGE si celui-ci existe et possède une Ref temporaire
        // ------------------------------------------------------------------------------------

        echo "refuser = $REFUSR, tmp = $REFTMP";

        $refsrc = "tmp" . $REFTMP;
        $refdst = $REFUSR;

        $or_src = PhotoHelpers::initPathPhoto($NOM, $PRENOM, $refsrc, PhotoHelpers::ORIGINAL);
        $th_src = PhotoHelpers::initPathPhoto($NOM, $PRENOM, $refsrc, PhotoHelpers::THUMBNAIL);
        $op_src = PhotoHelpers::initPathPhoto($NOM, $PRENOM, $refsrc, PhotoHelpers::OPERATIONS);

        $or_dst = PhotoHelpers::initPathPhoto($NOM, $PRENOM, $refdst, PhotoHelpers::ORIGINAL);
        $th_dst = PhotoHelpers::initPathPhoto($NOM, $PRENOM, $refdst, PhotoHelpers::THUMBNAIL);
        $op_dst = PhotoHelpers::initPathPhoto($NOM, $PRENOM, $refdst, PhotoHelpers::OPERATIONS);

        if (file_exists($or_src)) {
            if (rename($or_src, $or_dst) == false) {
                echo "erreur rename de $or_src vers $or_dst";
            }
        } else {
            echo "erreur fichier image inexistant : $or_src";
        }
        if (file_exists($th_src)) {
            if (rename($th_src, $th_dst) == false) {
                echo "erreur rename de $th_src vers $th_dst";
            }
        }
        if (file_exists($op_src)) {
            if (rename($op_src, $op_dst) == false) {
                echo "erreur rename de $op_src vers $op_dst";
            }
        }
    }

    // Suppression de la ligne dans table_temp

    $db->query("delete from @#@liste_temp where Ref = '$REFTMP'");

    // Initialisation de REFUSR et de la variable de session REFUSER avec la ref de la ligne
    // de la table 'liste' qui pointe vers les données de l'adhérent
    // ------------------------------------------------------------------------------------

    Session::setRefUser($REFUSR);

    // Sauvegarde des données POST

    Session::set('POST', $_POST);


    // Si c'etait une revue de dossier avec l'utilisateur alors on valide le dossier remis dans AdminOK

    if (Session::isInscriptionModeToOther()) {
        // Si c'est une revue de dossier
        //$adminok = Form::get('ADMINOK');
        $aok = new Adminok();
        $aok->set('DOSS', 'OK');
        $string = $aok->getString();
        $db->query("update @#@liste set ADMINOK = '$string' where Ref = $REFUSR");
    }
    // Redirection vers la page suivante


    if (Globals::getConf()->paymentPaypal) {
        Session::redirection('index_inscription_paiement.php');
    } else {
        Session::redirection('index_inscription_fin.php');
    }
    exit;
}
