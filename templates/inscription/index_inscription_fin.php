<?php

namespace App\Inscription;

use App\Incl\Classes\Error;
use App\Incl\Classes\Form;
use App\Incl\Classes\Globals;
use App\Incl\Classes\GucDate;
use App\Incl\Classes\PhotoHelpers;
use App\Incl\Classes\Session;

use App\Incl\Html\Header;
use App\Incl\Multifield\Diplomes;

use App\Incl\Log\LogAppli;

use App\Incl\Mail\HtmlToTxt;
use App\Incl\Mail\MailMime;

use App\Incl\Config\Config;
use App\Incl\Config\MailUsers;

session_start();

include_once __DIR__ . '/../bootstrap.php';

LogAppli::logAppli(LogAppli::LOGOK, "Check inscription");

if (!Session::isOpen()) {
    //db_log_message("+ERR : fonction check_inscription.php - NOM et/ou PRENOM non initialisés");
    echo "erreur 84091\n";
    exit;
}

Form::initialise(null, Session::get('POST'));

/**
 * @param $liste
 * @param bool $html
 * @return string
 */
function aff_mails($liste, $html = false)
{
    $idx=0;
    $buffer = "";

    foreach ($liste as $nom => $mail) {
        if ($html) {
            if ($idx++ > 0) {
                $buffer .= " ou ";
            }
            $buffer .= "<a href=\"mailto:".$mail."\">".$nom."</a> (".$mail.")";
        } else {
            if ($idx++ > 0) {
                $buffer .= " ou ";
            }
            $buffer .= $nom." (".$mail.")";
        }
    }
    return $buffer;
}

/**
 * @param $Ref
 * @param $Activite
 * @param $photo
 * @param $age
 * @param $Niveau
 * @param $Licence
 * @param $CarteSIUAPS
 * @param $PretMat
 * @param $total
 * @param $totalass
 * @param $texte_specifique
 * @return string
 */
function create_mail_body(
    $Ref,
    $Activite,
    $photo,
    $age,
    $Niveau,
    $Licence,
    $CarteSIUAPS,
    $PretMat,
    $total,
    $totalass,
    $texte_specifique
) {

    $db = Globals::getDb();
    $res = $db->query("select PaymentID,PaymentDate,PaymentAmount from @#@liste where Ref=$Ref");
    $val = $db->nextrow($res);
    $refPP   = $val['PaymentID'];
    if ($refPP != '') {
        $tmp = $val['PaymentDate'];
        $dat = explode(' ', $tmp);
        $pDate = GucDate::dmg($dat[0]);
        $pTime = $dat[1];
        $pAmount = $val['PaymentAmount'];
    }

    $userbody = "\n<p>Votre pré-inscription est enregistrée.</p>";
    if ($Activite== "Section Enfants" && !Config::$insc_enfants) {
        $userbody .= "<p><font color=\"#FF0000\">Mais attention, la section enfants est complète, ".
            "contactez par mail ".aff_mails(Config::$resp_enfants)."</font></p>\n";
    }
    if ($Activite== "Prépa N1" && !Config::$insc_N1) {
        $userbody .= "<p><font color=\"#FF0000\">Mais attention, la section prépa N1 est complète, ".
            "contactez par mail ".aff_mails(Config::$resp_N1)."</font></p>\n";
    }
    if ($Activite== "Prépa N2" && !Config::$insc_N2) {
        $userbody .= "<p><font color=\"#FF0000\">Mais attention, la section prépa N2 est complète, ".
            "contactez par mail ".aff_mails(Config::$resp_N2)."</font></p>\n";
    }
    if ((($Activite == 'Apnée Débutants') ||
            ($Activite == 'Apnée Confirmés') ||
            ($Activite == 'Apnée Initiateur')) && !Config::$insc_apnee) {
        $userbody .= "<p><font color=\"#FF0000\">Mais attention, la section apnée étant complète, ".
            "votre inscription ne pourra être validée qu'après avoir contacté par mail ".
            aff_mails(Config::$resp_apnee)."</font></p>\n";
    }
    if (($refPP != '') && Globals::getConf()->paymentPaypal) {
        $userbody.="<p>Votre paiement d'un montant de {$pAmount}€ a été fait le $pDate à $pTime sous la référence PayPal : ".$refPP."</p>\n";
    }
    $userbody.="<p>Votre numéro d'adhérent est le : ".$Ref."</p>\n";
    $userbody.="<p>Votre inscription deviendra définitive lorsque vous aurez apporté tous les documents demandés ";
    $userbody.="lors des permanences inscriptions qui se tiendront dès 19h00 chaque ";
    $userbody.="Mardi dans le hall de la piscine de Saint Martin d'Hères a compter du ".Config::DATE_DOSSIER.".</p>\n";
    if (Form::get('FACTURE') == 'CAESUG') {
        $userbody.= "<p>Vous avez déclaré vouloir utiliser les services du CAESUG pour régler la cotisation au Club. ".
            "En plus du dossier au GUC PLONGEE, vous devez donc maintenant faire votre dossier CAESUG Plongée".
            " et faire parvenir votre participation au CAESUG en suivant les consignes se trouvant sur leur ".
            "site Internet. Le contact CAESUG pour la plongée est ".
            "<a href=\"mailto:".Config::MAIL_CAESUG."\">".Config::NOM_CAESUG."</a></p>\n";
    }
    if (Form::get('FACTURE') == 'OUI') {
        $userbody.="<p>Vous avez demandé une facture. Celle-ci vous sera envoyée lors de la validation ".
            "définitive de votre inscription</p>\n";
    }

    $userbody.=$texte_specifique;

    $userbody.="Ce document a été transmis au secrétariat du club.</p>\n";
    $userbody.="<p>Vous devez maintenant :</p><ul>\n";
    $userbody.="<li>Imprimer, relire et vérifier soigneusement le document.";
    $userbody.=" Si vous détéctez des erreurs, vous pouvez modifier votre";
    $userbody.=" inscription (inscription -> Réinscription ou modification)</li>";
    $userbody.="<li>Lire le règlement intérieur.</li>\n";
    $userbody.="<li>Signer le document PDF, qui valide les données transmises et votre ".
        "acceptation du règlement intérieur.</li>";
    if ($age < 18) {
        $userbody.="<li>Faire signer le cadre d'autorisation parentale par le représentant légal.</li>\n";
    }

    $userbody.="</ul>\n<p>N'oubliez pas de joindre :</p><ul>";
    switch ($photo) {
        case "OK":
        case "BADSIZE":
            break;
        case "ERREURLECTURE":
        case "NOTFOUND":
            $userbody .= "<li>Une photo d'identité (avec votre nom et prénom au dos).</li>\n";
            break;
        default:
            $userbody .= "<li>Une photo d'identité (avec votre nom et prénom au dos) [".$photo."].</li>\n";
            break;
    }

    if ($Niveau != "Débutant" && $Niveau != "Enfant") {
        $userbody .= "<li>Une photocopie de votre ".$Niveau.".</li>\n";
    }

    $fDip = new Diplomes();
    $fDip->initFromVal(Form::get('DIPLOMES'));
    $liste_diplomes = $fDip->enum(',', 'OUI');

    if ($liste_diplomes != "") {
        $userbody .= "<li>Une photocopie de vos diplomes -> ".$liste_diplomes.". ";
        $userbody .= "(Les photocopies des diplômes sont facultatives si le club les a déjà).</li>\n";
    }
    $userbody .= "<li>Une photocopie de votre certificat médical.</li>\n";
    if (Form::get('LICENCE')== "Autre Club") {
        $userbody .= "<li>Une photocopie de votre licence ".Config::$p_annee."-".(Config::$p_annee+1).".</li>\n";
    }
    if (Form::get('CARTESIUAPS')== "NON") {
        $userbody .= "<li>Une photocopie de votre carte SIUAPS ".Config::$p_annee."-".(Config::$p_annee+1).".</li>\n";
    }

    if ($refPP == '') {
        $userbody .= "<li>Un chèque de " . $total . "€ à l'ordre du GUC Plongée.</li>\n";
        if ($totalass > 0) {
            $userbody .= "<li>Un chèque de " . $totalass . "€ à l'ordre de AXA Assurance.</li>\n";
        }
    }
    if (Form::get('PRETMAT') == "OUI") {
        $userbody .= "<li>Un chèque de caution de " . Config::CAUTION_MATOS . "€ à l'ordre du GUC Plongée " .
            "pour le prêt de matériel.</li>\n";
    }

    $userbody .= "<li>Un chèque de caution de ".Config::BADGE_PISCINE."€ à l'ordre du GUC Plongée ".
        "pour le badge d'accès piscine.</li>\n";
    $userbody .= "</ul></p>\n<p>Merci et à bientôt.</p>\n";
    return $userbody;
}


$REFUSR = Session::get('REFUSR');
$MODIFUSER = Session::get('MODIFUSER');
$NOM = Session::get('NOM');
$PRENOM = Session::get('PRENOM');

$l = new Calculate();

/** @var Error $e Créée par le script appelant */

$post = Session::get('POST');
Form::initialise(null, $post);

$cotis = $l->calcCotis(Form::getArray());
$axa   = $l->calcAxa(Form::get('ASSURANCE'));

// Calcul Cotisation

$mytotal    = $cotis['prixCotis'] + $cotis['prixLicence'] - $cotis['prixReduc'] - $cotis['prixRemb'];         // Montant cotisation
$mytotalass = $axa  ['prixAxa' ];                               // Montant assurance
$fbene      = $cotis['fBene'];         // Bénévole
$fenc       = $cotis['fEnc'];          // Encadrant actif

$age_today = GucDate::age(Form::get('DATENAISS'));
$Activite  = GucDate::age(Form::get('ACTIVITE'));



// Génération du PDF
    
// Initialisation de ces variables pour pointer correctement le path du fichier généré
// selon que l'on à affaire à un lien dans une page HTML ($path).
// Ou un lien dans un mail ($path_mail)
// ------------------------------------------------------------------------------------
    
$tronc = $NOM."-".$PRENOM."-".$REFUSR;
$path_corr   = PhotoHelpers::corrigerPath(Config::$path_fiches);
$path_adher  = PhotoHelpers::corrigerPath($tronc.".pdf");
$path_livret = PhotoHelpers::corrigerPath("../docs/livret_accueil_GUC.pdf");

$path_ident = PhotoHelpers::initPathPhoto($NOM, $PRENOM, $REFUSR, PhotoHelpers::THUMBNAIL);

(new CreatePDF())->createPDF(
    $REFUSR,
    $NOM,
    $PRENOM,
    $path_corr.$path_adher,
    $path_ident,
    $age_today,
    $mytotal,
    $mytotalass,
    $fbene,
    $fenc
);

// Envoi du mail vers le webmaster pour signaler un nouvel inscrit ou bien une mise à jour
// ------------------------------------------------------------------------------------

$sujet="Inscription GUC Plongée";

$body_text  = "\n*************************\n";
$body_text .= "Nom     : ".$NOM."\n";
$body_text .= "Prénom  : ".$PRENOM."\n";
$body_text .= "Ref     : ".$REFUSR."\n";
$body_text .= "OLD/NEW : ".$MODIFUSER."\n";
$body_text .= "\n*************************\n";

$body_html  = "<html><head></head><body>\n";
$body_html .= "<table border=\"1\" width=\"400\" style=\"border-collapse:collapse;\">\n";
$body_html .= "<tr><th>Nom</th><th>Prénom</th><th>Ref</th><th>OLD/NEW</th></tr>\n";
$body_html .= "<tr><td>".$NOM."</td><td>".$PRENOM."</td><td>".$REFUSR."</td><td>".$MODIFUSER."</td></tr>\n";
$body_html .= "</table>\n";
$body_html .= "</body></html>\n";

//$sender = "Inscriptions GUC Plongee <contact@guc-plongee.net>";
$sender = "contact@guc-plongee.net";

(new MailMime())->mimeMail(
        $sender,
        MailUsers::$webmaster,
        $sujet,
        $body_text,
        $body_html);

// Envoi du mail vers l'adhérent avec toutes les infos.
// ------------------------------------------------------------------------------------

$userdest  = Form::get('MAIL');
$usersujet = "Pre-inscription GUC Plongee pour la saison ".Config::$p_annee."-".(Config::$p_annee+1);

$texte_spec = "<p>Vous trouverez en attachement de ce mail le livret d'accueil du GUC Plongée ".
              "et votre dossier d'inscription PDF pré-rempli. ";
$mail_html = create_mail_body(
    $REFUSR,
    $Activite,
    Session::get('PHOTO'),
    $age_today,
    Form::get('NIVEAU'),
    Form::get('LICENCE'),
    Form::get('CARTESIUAPS'),
    Form::get('PRETMAT'),
    $mytotal,
    $mytotalass,
    $texte_spec
);

$mail_text = (new HtmlToTxt())->html2txt($mail_html);
$filename = $tronc.'.pdf';

$ml = new MailMime();

$ml->init($sender, $userdest, $usersujet, $sender);
$ml->setDkimSign(true);
$ml->addAlternative($mail_text, $mail_html);

$ret_form = $ml->addFile($path_corr, $path_adher);
$ret_accl = $ml->addFile('../docs', $path_livret);
$retsend  = $ml->send();

// Si demande de bénévolat, alors envoi de mail a Président, secrétaire, webmaster

if (Form::get('BENEVOLE') == 'OUI') {
    $sujet      = "Demande de poste bénévole GUC Plongée";

    $body_text  = "\n*************************\n";
    $body_text .= "Nom     : ".$NOM."\n";
    $body_text .= "Prénom  : ".$PRENOM."\n";
    $body_text .= "Ref     : ".$REFUSR."\n";
    $body_text .= "OLD/NEW : ".$MODIFUSER."\n";
    $body_text .= "Niv SCA : ".g('NIVEAU')."\n";
    $body_text .= "Niv APN : ".g('APNEE')."\n";
    $body_text .= "\n*************************\n";

    $body_html  = "<html><head></head><body>\n";
    $body_html .= "<table border=\"1\" width=\"400\" style=\"border-collapse:collapse;\">\n";
    $body_html .= "<tr><th>Nom</th><th>Prénom</th><th>Ref</th><th>OLD/NEW</th><th>Niv SCA</th>";
    $body_html .= "<th>Niv APN</th></tr>";
    $body_html .= "<tr><td>$NOM</td><td>$PRENOM</td><td>$REFUSR</td><td>$MODIFUSER</td>";
    $body_html .= "<td>".Form::get('NIVEAU')."</td><td>".Form::get('APNEE')."</td></tr>\n";
    $body_html .= "<tr><td colspan=\"6\">Email = <a href=\"mailto:".$userdest."\">".$userdest."</a></td></tr>\n";
    $body_html .= "</table>\n";
    $body_html .= "</body></html>\n";

    $ml = new MailMime();

    $sender     = "Inscriptions GUC Plongee <contact@guc-plongee.net>";
    $ml->init($sender, MailUsers::$dest_benevole, $sujet, $userdest);
    $ml->setDkimSign(true);
    $ml->addAlternative($body_text, $body_html);

    $ml->send();
}

// ************************************************************************************
// affiche le html qui suit si succes
// ************************************************************************************

$html = new Header('..');
$html->start('Inscription');
?>
    <div class="container">
        <h3>Votre pré-inscription est enregistrée</h3>
        <div class="col-xs-12">
<?php
if ($ret_form == false) {?>
                <p class="red">Erreur : impossible d'attacher votre fiche PDF au mail de confirmation,
                       contactez le webmaster au moyen de la rubrique contact</p>
<?php
}
if ($retsend == false) {?>
                <p class="red">Erreur d'envoi du mail, contactez le webmaster au moyen de la rubrique contact</p>
<?php
}
if ($ret_form == false || $retsend == false) {
    $texte_web = "<p>Votre formulaire PDF peut être téléchargé ".
                 "<a href=\"".Globals::getConf()->url_web."insc/$filename?a=".rand(0, 9999)."\" target=\"_blank\">ici</a>.</p>";
} else {
    $texte_web = "<p>Votre formulaire PDF se trouve en attachement dans le mail qui vous à été envoyé, ".
                 "vous pouvez néanmoins le télécharger ".
                 "<a href=\"".Globals::getConf()->url_web."insc/".$filename."\" target=\"_blank\">ici</a>.</p> ";
}
if ($ret_accl == false) {
    $texte_web .= "<p>Le livret d'accueil du GUC Plongée peut être téléchargé ".
                  "<a href=\"".Globals::getConf()->url_web."docs/livret_accueil_GUC.pdf\" target=\"_blank\">ici</a>.</p>";
} else {
    $texte_web .= "<p>Le livret d'accueil du GUC Plongée se trouve également en attachement dans le mail ".
                  "qui vous à été envoyé, vous pouvez néanmoins le télécharger ".
                  "<a href=\"".Globals::getConf()->url_web."docs/livret_accueil_GUC.pdf\" target=\"_blank\">ici</a>.</p> ";
}
echo create_mail_body(
    $REFUSR,
    $Activite,
    Session::get('PHOTO'),
    $age_today,
    Form::get('NIVEAU'),
    Form::get('LICENCE'),
    Form::get('CARTESIUAPS'),
    Form::get('PRETMAT'),
    $mytotal,
    $mytotalass,
    $texte_web
);
?>
</div></div>
<?php $html->end();
