<?php

namespace App\Inscription;

use App\Incl\Classes\Error;
use App\Incl\Classes\Form;
use App\Incl\Classes\Globals;
use App\Incl\Classes\Session;

use App\Incl\Config\Config;

use App\Incl\Html\Header;
use App\Incl\Mail\HtmlToTxt;
use App\Incl\Mail\MailMime;
use App\Incl\Config\MailUsers;
use DateTime;

include_once __DIR__ . '/../bootstrap.php';

if (!Session::isOpen()) {
    echo "erreur 84091\n";
    exit;
}

/** @var Error $e */

/**
 * @param $Ref
 * @param $total
 * @param $totalass
 * @return string
 */
function create_mail_body($Ref, $total, $totalass)
{
    if ($totalass != "") {
        $tass = "<li>Un chèque de ".$totalass." € à l'ordre de AXA Assurance.</li>\n";
    } else {
        $tass = "";
    }

    $userbody = <<<EOD
<p>Votre demande de licence passager est enregistrée. Votre numéro d'adhérent est le : $Ref</p>
<p>Elle deviendra définitive lorsque vous aurez fait parvenir au secrétariat tous les documents demandés.</p>
<p>Voici les documents à nous faire parvenir :<ul>
<li>Une photocopie de votre certificat médical.</li>
<li>Un chèque de $total € à l'ordre du GUC Plongée</li>
$tass
</ul>
<p>Vous pouvez soit remettre ces documents le Mardi a partir de 19h30 à la piscine du campus de Saint-Martin d'Hères
mais également les envoyer par courrier à :</p>


GUC PLONGEE<br>
Chez Guy VERE<br>
33 avenue Ambroise Croizat<br>
38600 FONTAINE<br>



<p>Merci et à bientôt.</p>
EOD;
    
    return $userbody;
}

// Vérifier la date de naissance



// Début des traitements : Les données formulaires ont déjà été traitées avec
// la fonction Initialise()
// ---------------------------------------------------------------------------

ExecAffCheck::execCheck(ExecAffCheck::PASSAGER, $e);

$db = Globals::getDb();

if ($e->getNbErrors() == 0) {
    // Calcul Licence

    $l = new Calculate();

    $cotis = $l->calcLicence(new DateTime($_POST['DATENAISS']), false);
    $axa   = $l->calcAxa($_POST['ASSURANCE']);

    if ($cotis['fErr']) {
        $e->error(6, 1, "Erreur, calcul licence  impossible, revérifiez votre saisie");
    } else {
        Form::set('LICENCE', $cotis['typeLicence']);
    }

    $date = date("Y-m-d");
    
    // Toute les informations sont correctes
    // On va transférer la ligne de la table 'liste_temp' vers 'liste'
    // 2 cas de figure: l'adhérents existe , ou n'existe pas
    // -------------------------------------------------------------------
    
    // ------------------------------------------------------------------------
    // REFUSRADHERENT contient :
    // Soit la référence valide d'un adhérent existant.
    //  - Dans ce cas, on recopie les données de la ligne dans la table liste_temp
    //    vers la table 'liste', et on supprime la ligne de 'liste_temp'.
    //    L'image a normalement déjà le bon nom
    // Soit une référence temporaire qui commence par le préfixe 'REF-'
    //  - Dans ce cas, crée la ligne définitive de l'adhérent dans la table 'liste'
    //    puis on recopie les données de la ligne dans la table liste_temp, et on
    //    supprime la ligne de 'liste_temp'.
    //    L'image doit aussi être renommée -> 'nom-prenom-reftemp' vers 'nom-prenom-ref'
    // ------------------------------------------------------------------------
    // Pour savoir, on va tenter de lire l'enregistrement dans la table 'liste'
    // pointée par REFUSRADHERENT.
    // Si on trouve une ligne, c'est que la REF pointe vers le bon adhérent
    // Si on ne trouve rien, c'est que REFUSRADHERENT est une REF temporaire
    // ------------------------------------------------------------------------
    
    $sql = "SELECT MODIFUSER FROM @#@liste where Ref='".Session::get('REFUSR')."'";
    $resultat = $db->query($sql);

    $data = $db->nextrow($resultat);
    
    $SQL = Form::getSQL(true, Form::PASSAGER);

    if ($data != false) {
        // L'adhérent est dans la base avec cette REFUSR
        // On recopie les données du formulaire validé vers
        // la ligne existante de 'liste'
        // ------------------------------------------------------------------------------------

        // On conserve l'information MODIFUSER si celle-ci est != ''

        if ($data['MODIFUSER'] == '') {
            $MODIFUSER = 'OLD';
        } else {
            $MODIFUSER = $data['MODIFUSER'];
        }
        
        $db->query("update @#@liste set $SQL,".
                        "COTISATION='Passager',".
                        "ACTIVITE='Passager',".
                        "ADMINOK       = 'NON',".
                        "MODIFUSER     = '$MODIFUSER',".
                        "DATEMODIFUSER = '$date'".
                        " where Ref = '".Session::get('REFUSR')."'");
        
        // Init de NEWREF pour pouvoir repositionner la variable de session REFUSR
        // à la fin de ces traitements
        // ------------------------------------------------------------------------------------
        
        $NEWREF = Session::get('REFUSR');
    } else {
        // L'adhérent n'est pas dans la base avec cette REFUSR
        // Cela veut dire que l'adhérent est à créer
        // On recopie les données du formulaire validé vers une
        // nouvelle ligne dans 'liste'
        // ------------------------------------------------------------------------------------
        
        $sq = "insert into @#@liste set $SQL,".
                        "NOM    ='".Session::get('NOM')."',".
                        "PRENOM ='".Session::get('PRENOM')."',".
                        "PASSWD ='".Session::get('PASSWD')."',".
                        "COTISATION='Passager',".
                        "ACTIVITE='Passager',".
                        "ADMINOK='NON',".
                        "MODIFUSER = 'NEW',".
                        "DATEMODIFUSER = '$date',".
                        "DATEPREMINSCR = '$date'";
        $db->query($sq);
        
        // Récuperation de la REFUSR créée
        
        $NEWREF = $db->last_insert_id();
    }

    // Suppressionde la ligne dans table_temp
        
    $db->query("delete from @#@liste_temp where Ref = '".Session::get('REFUSR')."'");
    
    // Initialisation de REFUSR et de la variable de session REFUSER avec la ref de la ligne
    // de la table 'liste' qui pointe vers les données de l'adhérent
    // ------------------------------------------------------------------------------------
    
    Session::set('REFUSR', $NEWREF);
    Session::setRefUser(Session::get('REFUSR'));
    
    // Génération du PDF
    
    // Initialisation de ces variables pour pointer correctement le path du fichier généré
    // selon que l'on à affaire à un lien dans une page HTML ($path).
    // Ou un lien dans un mail ($path_mail)
    // ------------------------------------------------------------------------------------
    
    // Envoi du mail vers le webmaster pour signaler un nouvel inscrit ou bien une mise à jour
    // ------------------------------------------------------------------------------------

    $sujet="Inscription GUC Plongée - Licence Passager";

    $body_text  = "\n*************************\n";
    $body_text .= "Nom     : ".Session::get('NOM')."\n";
    $body_text .= "Prénom  : ".Session::get('PRENOM')."\n";
    $body_text .= "Ref     : ".Session::get('REFUSR')."\n";
    $body_text .= "OLD/NEW : ".Session::get('MODIFUSER')."\n";
    $body_text .= "\n*************************\n";
    
    $body_html  = "<html><head></head><body>\n";
    $body_html .= "<table border=\"1\" width=\"400\" style=\"border-collapse:collapse;\">\n";
    $body_html .= "<tr><th>Nom</th><th>Prénom</th><th>Ref</th><th>OLD/NEW</th></tr>\n";
    $body_html .= "<tr><td>".Session::get('NOM')."</td><td>".Session::get('PRENOM')."</td><td>".
                             Session::get('REFUSR')."</td><td>".Session::get('MODIFUSER')."</td></tr>\n";
    $body_html .= "</table>\n";
    $body_html .= "</body></html>\n";

    $sender = "Inscriptions GUC Plongee <contact@guc-plongee.net>";
    
    (new MailMime())->mimeMail(
        $sender,
        MailUsers::$webmaster,
        $sujet,
        $body_text,
        $body_html
    );

    // Envoi du mail vers l'adhérent avec toutes les infos.
    // ------------------------------------------------------------------------------------

    $userdest  = Form::get('MAIL');
    $usersujet = "GUC Plongee - Licence passager pour la saison ".Config::$p_annee."-".(Config::$p_annee+1);

    $mail_html = create_mail_body(
        Session::get('REFUSR'),
        $cotis['prixLicence'],
        $axa['prixAxa']
    );

    $mail_text = (new HtmlToTxt())->html2txt($mail_html);

    $ml = new MailMime();

    $ml->init($sender, $userdest, $usersujet, $sender);
    $ml->setDkimSign(true);
    $ml->addAlternative($mail_text, $mail_html);
    
    $retsend = $ml->send();

    // ************************************************************************************
    // affiche le html qui suit si succes
    // ************************************************************************************

    $html = new Header('..');
    $html->start('Inscription Passager');
    ?>

        <div class="container">
            <div class="col-xs-12">
                <h3>Votre pré-inscription est enregistrée</h3>
            </div>
            <div class="col-xs-12">
<?php
if ($retsend == false) {?>
                <p class="red">Erreur d'envoi du mail, contactez le webmaster au moyen de la rubrique contact</p>
            </div>
            <div class="col-xs-12">
<?php
}
echo $mail_html;
?>
            </div>
        </div>
<?php $html->end();

// On ferme la page HTML
// *** ET ON NE REVIENT PAS DANS LE SCRIT APPELANT
exit();
}
?>
