<?php

namespace App\Controller\Inscription;

use App\Classes\Config\Config;
use App\Classes\Helpers\DateHelper;
use App\Classes\Form\FormConst;
use App\Classes\Helpers\FileHelper;
use App\Classes\Inscription\Calculate;
use App\Entity\Adherent;
use App\Entity\Diplome;
use DateInterval;
use DateTime;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class AdherentValidator
{
    /**
     * @var string fonction Javascript appelée lorsque le contenu d'un champ change
     */
    static private $oc   = "attr:onchange=\"adaptprix()\"";

    /**
     * @var array Paramétrage des différents champs des formulaires d'inscription (normal et passager)
     *
     * @uses affInstrNorm, affInstrPassager, affInfperso, affGenre, affAddress, affProf, affEtud, affDnaiss, affTel
     * @uses affMail, affPhoto, affNiv, affDipl, affActi, affBene, affMedic, affAcci, affDcertif, affAspi, affLic
     * @uses affAss, affCalcul, affReducfam, affFact, affPret, affBadge, affInfoperso, affMailliste
     * @uses affReglement, affRGPD, affMineur, affConfirm
     *
     * @uses checkGenre, checkAddress, checkProf, checkDnaiss, checkTel, checkMail, checkPhoto, checkNiv, checkDipl
     * @uses checkActi, checkAcci, checkDcertif, checkAspi, checkLic, checkAss, checkReducfam, checkPret
     * @uses checkMailliste, checkReglement, checkRGPD, checkMineur,

     */
    static private $fields = [
        [FormConst::INSCR_PASSAGER => true,  FormConst::INSCR_NORMAL => true,  'check' => 'checkAddress'],
        [FormConst::INSCR_PASSAGER => true,  FormConst::INSCR_NORMAL => true,  'check' => 'checkProf'],
        [FormConst::INSCR_PASSAGER => true,  FormConst::INSCR_NORMAL => true,  'check' => 'checkDnaiss'],

        [FormConst::INSCR_PASSAGER => false, FormConst::INSCR_NORMAL => true,  'check' => 'checkTel'],
        [FormConst::INSCR_PASSAGER => true,  FormConst::INSCR_NORMAL => true,  'check' => 'checkNiv'],
        [FormConst::INSCR_PASSAGER => false, FormConst::INSCR_NORMAL => true,  'check' => 'checkDipl'],
        [FormConst::INSCR_PASSAGER => false, FormConst::INSCR_NORMAL => true,  'check' => 'checkActi']/*,
        [FormConst::INSCR_PASSAGER => false, FormConst::INSCR_NORMAL => true,  'check' => 'checkAcci'],
        [FormConst::INSCR_PASSAGER => false, FormConst::INSCR_NORMAL => true,  'check' => 'checkAspi'],
        [FormConst::INSCR_PASSAGER => true,  FormConst::INSCR_NORMAL => true,  'check' => 'checkDcertif'],
        [FormConst::INSCR_PASSAGER => false, FormConst::INSCR_NORMAL => true,  'check' => 'checkLic'],
        [FormConst::INSCR_PASSAGER => true,  FormConst::INSCR_NORMAL => true,  'check' => 'checkAss'],
        [FormConst::INSCR_PASSAGER => false, FormConst::INSCR_NORMAL => true,  'check' => 'checkReducfam'],
        [FormConst::INSCR_PASSAGER => false, FormConst::INSCR_NORMAL => true,  'check' => 'checkPret'],
        [FormConst::INSCR_PASSAGER => true,  FormConst::INSCR_NORMAL => true,  'check' => 'checkMailliste'],
        [FormConst::INSCR_PASSAGER => false, FormConst::INSCR_NORMAL => true,  'check' => 'checkReglement'],
        [FormConst::INSCR_PASSAGER => false, FormConst::INSCR_NORMAL => true,  'check' => 'checkMineur'],
        [FormConst::INSCR_PASSAGER => false, FormConst::INSCR_NORMAL => true,  'check' => 'checkPhoto']*/
    ];

    private static function e($context,$text,$var)
    {
        $context->buildViolation($text)
            ->atPath($var)
            ->addViolation();

    }

    /**
     * Vérification des champs d'adresse
     * @param Adherent $user
     * @param ExecutionContextInterface $context
     */
    private static function checkAddress(Adherent $user, ExecutionContextInterface $context)
    {
        // *********************************************************************
        // verifier addresse != 0
        // *********************************************************************
        if ($user->getAdresse1() == "") {
            self::e($context,"Vous n'avez pas mis votre adresse.", 'Adresse1');
        }

        // *********************************************************************
        // verifier code postal = 5 chiffres
        // *********************************************************************
        $codep = $user->getCodePostal();
        if (!preg_match('/[0-9][0-9][0-9][0-9][0-9]/', $codep) || (strlen($codep) != 5)) {
            $context->buildViolation("Votre code postal est incorrect.")
                ->atPath('CodePostal')
                ->addViolation();
        }

        // *********************************************************************
        // verifier ville != 0
        // *********************************************************************
        if ($user->getVille() == "") {
            $context->buildViolation("Vous n'avez pas mis votre ville.")
                ->atPath('Ville')
                ->addViolation();
        }
    }

    /**
     * Vérification de la saisie du champ profession
     * @param Adherent $user
     * @param ExecutionContextInterface $context
     */
    private static function checkProf(Adherent $user, ExecutionContextInterface $context)
    {
        if ($user->getProfession() == "") {
            $context->buildViolation("Vous n'avez pas mis votre profession.")
                ->atPath('Profession')
                ->addViolation();
        }
    }

    /**
     * Fonction de check de la date de naissance
     * @param Adherent $user
     * @param ExecutionContextInterface $context
     */
    private static function checkDnaiss(Adherent $user, ExecutionContextInterface $context)
    {
        // *********************************************************************
        // calcul de l'âge
        // *********************************************************************
        // Deux 'ages' à predre en compte:
        // - L'age au moment de l'inscription
        // - L'age après le 31/12 de l'année
        // *********************************************************************

        // Vérification de la date

        $datenaiss = $user->getDateNaissance()->format('d/m/Y');

        switch (DateHelper::verifDate($datenaiss)) {
            case -1:
                self::e($context, "Votre date de naissance est incorrecte ($datenaiss).",'DateNaissance');
                break;
            case -2:
                self::e($context, "Votre date de naissance est incorrecte (2) ($datenaiss).", 'DateNaissance');
                break;
            case -3:
                self::e($context, "L'année de naissance est incorrecte.", 'DateNaissance');
                break;
            case -4:
                self::e($context, "L'année de naissance est incorrecte (3).",'DateNaissance');
                break;
            case 0:
                break; // Pas d'erreur
        }

        $age_finannee = DateHelper::age($datenaiss, "31/12/" . Config::$p_annee);

        if ($age_finannee < 10) {
            $context->buildViolation("Il est nécessaire d'avoir 10ans révolus au 01/01/" . (Config::$p_annee + 1) .
                " pour prendre une licence FFESSM et/ou vous inscrire au club.")
                ->atPath('DateNaissance')
                ->addViolation();
        }
    }

    /**
     * Helper de vérification des numéros de téléphone
     * @param $str
     * @return bool|null|string|string[]
     */
    private static function verifTel($str)
    {
        $tel = false;
        // Suppression des caractères spéciaux
        $res = str_replace(array('.', ' ', ',', '-', '/'), '', $str);
        // Que des chiffres ?
        if (!ctype_digit($res) && substr($res, 0, 3) == "+33") {
            if (ctype_digit(substr($res, 1)) && strlen($res) == 12) {
                $tel = preg_replace(
                    "#(\+)(\d{2})(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})#",
                    "0$3 $4 $5 $6 $7",
                    $res
                );
            }
        } else {
            if ($res[0] == '0' && strlen($res) == 10) {
                $tel = preg_replace(
                    "#(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})#",
                    "$1 $2 $3 $4 $5",
                    $res
                );
            }
        }
        return $tel;
    }

    /**
     * Vérification des numéros de téléphone
     * @param Adherent $user
     * @param ExecutionContextInterface $context
     */
    private static function checkTel(Adherent $user, ExecutionContextInterface $context)
    {
        $tel = $user->getTelFix();

        if ($tel != '') {
            if (($res = self::verifTel($tel)) == false) {
                $context->buildViolation("Votre numéro de téléphone fixe est incorrect.")
                    ->atPath('TelFix')
                    ->addViolation();
            } else {
                $user->setTelFix($res);
            }
        }

        $tel = $user->getTelPort();
        if ($tel != '') {
            if (($res = self::verifTel($tel)) == false) {
                $context->buildViolation("Votre numéro de téléphone portable est incorrect.")
                    ->atPath('TelPort')
                    ->addViolation();
            } else {
                $user->setTelPort($res);
            }
        }

        if (($user->getTelFix() == "") && ($user->getTelPort() == "")) {
            $context->buildViolation("Au moins un téléphone doit être renseigné.")
                ->atPath('TelFix')
                ->addViolation();
        }
    }

    /**
     * Vérification photo
     * @param Adherent $user
     * @param ExecutionContextInterface $context
     */
    private static function checkPhoto(Adherent $user, ExecutionContextInterface $context)
    {
        $NOM    = $user->getNom();
        $PRENOM = $user->getPrenom();
        $REFUSR = $user->getId();

        $path = FileHelper::initPathPhoto($NOM, $PRENOM, $REFUSR, FileHelper::THUMBNAIL);

        // Vérification de l'existence de l'image

        if (!file_exists($path)) {
            $context->buildViolation("Votre photo d'identité est manquante.")
                ->atPath('Photo')
                ->addViolation();
        }
    }

    /**
     * Vérification de la saisie des niveaux
     * @param Adherent $user
     * @param ExecutionContextInterface $context
     */
    private static function checkNiv(Adherent $user, ExecutionContextInterface $context)
    {
        $Niveau = $user->getNiveauSca();
        $Apnee = $user->getNiveauApn();
        $dnaiss = $user->getDateNaissance()->format('d/m/Y');

        $age_finannee = DateHelper::age($dnaiss, "31/12/" . Config::$p_annee);

        if ($Niveau == "") {
            $context->buildViolation("Vous n'avez pas renseigné votre niveau actuel de plongée scaphandre.")
                ->atPath('NiveauSca')
                ->addViolation();
        } else {
            if ($age_finannee < 13 && $Niveau != "Enfant") {
                $context->buildViolation("Agé de " . $age_finannee . " ans au 31/12/" . Config::$p_annee .
                    " et à moins de 14 ans, vous devez cocher enfant.")
                    ->atPath('NiveauSca')
                    ->addViolation();
            }

            if ($age_finannee >= 14 && $Niveau == "Enfant") {
                $context->buildViolation("Agé de " . $age_finannee . " ans au 01/01/" . (Config::$p_annee + 1) .
                    " et à partir de 14 ans, vous n'êtes plus considéré comme un enfant pour la FFESSM.")
                    ->atPath('NiveauSca')
                    ->addViolation();
            }
        }

        if ($Apnee == "") {
            $context->buildViolation("Vous n'avez pas renseigné votre niveau actuel d'apnée.")
                ->atPath('NiveauApn')
                ->addViolation();
        }
    }

    /**
     * Vérification des champs de saisie des diplômes
     * @param Adherent $user
     * @param ExecutionContextInterface $context
     */
    private static function checkDipl(Adherent $user, ExecutionContextInterface $context)
    {
        $dnaiss = $user->getDateNaissance()->format('d/m/Y');
        $age_today = DateHelper::age($dnaiss);
        $Niveau = $user->getNiveauSca();

        $diplomes = $user->getDiplomes();

        /** @var Diplome $diplome */
        foreach ($diplomes as $diplome) {

            switch ($diplome->getType()) {
                case 'TIV':
                    if ($age_today < 18) {
                        $context->buildViolation("Vous avez " . $age_today .
                            " ans et TIV implique que vous êtes majeur, vérifiez votre date de naissance.")
                            ->atPath('Diplomes')
                            ->addViolation();
                    }
                    if ($Niveau == "Débutant" || $Niveau == "N1" || $Niveau == "Enfant") {
                        $context->buildViolation("TIV implique que vous êtes au moins Niveau 2.")
                            ->atPath('Diplomes')
                            ->addViolation();
                    }
                    break;
            }
        }
    }

    /**
     * Vérification des champs de saisie d'activité
     * @param Adherent $user
     * @param ExecutionContextInterface $context
     */
    private static function checkActi(Adherent $user, ExecutionContextInterface $context)
    {
        $Niveau   = $user->getNiveauSca();
        $Apnee    = $user->getNiveauApn();
        $Activite = $user->getActivite();
        $dnaiss   = $user->getDateNaissance()->format('d/m/Y');

        $age_today    = DateHelper::age($dnaiss);
        $age_finannee = DateHelper::age($dnaiss, "31/12/" . Config::$p_annee);

        if ($Activite == "") {
            self::e($context, "Vous n'avez pas renseigné votre activité pour cette année.", 'Activite');
        }

        if (($Activite == FormConst::A_ENFANTS) && ($Niveau != FormConst::N_ENFANT)) {
            self::e($context,"Votre activité est incompatible avec votre niveau de plongée.", 'Activite');
        }

        if ($age_finannee >= 14 && $Activite == FormConst::A_ENFANTS) {
            self::e($context,"Vous êtes trop âgé  (" . $age_today . " ans) pour la section enfants.",'Activite');
        }

        if (($Activite == FormConst::A_PN1) &&
            ($Niveau   != FormConst::N_ENFANT) &&
            ($Niveau   != FormConst::N_DEBUT) &&
            ($Niveau   != FormConst::N_OWD)) {
            self::e($context,"Votre activité est incompatible avec votre niveau de plongée.",'Activite');
        }

        if (($Activite == FormConst::A_PN2) &&
            ($Niveau   != FormConst::N_N1) &&
            ($Niveau   != FormConst::N_PA2) &&
            ($Niveau   != FormConst::N_PE4) &&
            ($Niveau   != FormConst::N_OWD) &&
            ($Niveau   != FormConst::N_AOWD)) {
            self::e($context,"Votre activité est incompatible avec votre niveau de plongée.",'Activite');
        }

        if (($Activite == FormConst::A_PE4) &&
            ($Niveau   != FormConst::N_N1) &&
            ($Niveau   != FormConst::N_PA2) &&
            ($Niveau   != FormConst::N_OWD) &&
            ($Niveau   != FormConst::N_AOWD)) {
            self::e($context, "Votre activité est incompatible avec votre niveau de plongée.", 'Activite');
        }

        if (($Activite == FormConst::A_PN3) &&
            ($Niveau   != FormConst::N_PA4) &&
            ($Niveau   != FormConst::N_N2) &&
            ($Niveau   != FormConst::N_N2I) &&
            ($Niveau   != FormConst::N_RDMD)) {
            self::e($context, "Votre activité est incompatible avec votre niveau de plongée.",'Activite');
        }

        if ($Activite == FormConst::A_PN4) {
            if (($Niveau != FormConst::N_N3) &&
                ($Niveau != FormConst::N_N3I)) {
                self::e($context, "Votre activité est incompatible avec votre niveau de plongée.",'Activite');
            }
        }

        if ($Activite == FormConst::A_PINITIATEUR) {
            if (($Niveau != FormConst::N_N2) &&
                ($Niveau != FormConst::N_N3) &&
                ($Niveau != FormConst::N_N4)) {
                self::e($context, "Votre activité est incompatible avec votre niveau de plongée.", 'Activite');
            }
        }

        if ($Activite == FormConst::A_PMF1) {
            if (($Niveau != FormConst::N_N4) &&
                ($Niveau != FormConst::N_N4I)) {
                self::e($context, "Votre activité est incompatible avec votre niveau de plongée.", 'Activite');
            }
        }

        if ($Activite == FormConst::A_ENCADREMENT) {
            if (($Niveau != FormConst::N_N2I)  && ($Niveau != FormConst::N_N3I) &&
                ($Niveau != FormConst::N_N4)   && ($Niveau != FormConst::N_N4I) &&
                ($Niveau != FormConst::N_MF1)  && ($Niveau != FormConst::N_MF2) &&
                ($Apnee  != FormConst::N_A2I)  && ($Apnee  != FormConst::N_A3I) &&
                ($Apnee  != FormConst::N_A4)   && ($Apnee  != FormConst::N_A4I) &&
                ($Apnee  != FormConst::N_MEF1) && ($Apnee  != FormConst::N_MEF2)) {
                self::e($context, "Pour encadrer, vous devez avoir un diplôme d'encadrant.", 'Activite');
            }
        }

        // Calcul Cotisation

        $cal = new Calculate();
        $ret = $cal->calcCotis($user);

        if ($ret['fErr']) {
            self::e($context, "Erreur, calcul cotisation impossible, revérifiez votre saisie (1)", 'Cotisation');
        } else {
            $user->setCotisation($ret['typeCotis']);
        }

        if ($user->getCotisation() == FormConst::COT_ENFANTS && $age_finannee >= 25) {
            self::e($context, "Vous devez être agé de moins de 18 ans ou " .
                "être étudiant de moins de 25 ans pour prendre cette cotisation.", 'Cotisation');
        }

        if ($user->getCotisation() == FormConst::COT_ENFANTS && $age_finannee >= 18 && !$user->getFEtudiant()) {
            self::e($context, "Vous devez être agé de moins de 18 ans ou " .
                "être étudiant de moins de 25 ans pour prendre cette cotisation.", 'Cotisation');
        }
    }

    /**
     * Vérification des champs de saisie de la personne à prevenir en cas d'accident
     * @param Error $e
     */
    private static function checkAcci(Error $e)
    {
        if (Form::get('ACCNOM') == "") {
            $e->error(6, 1, "Vous n'avez pas renseigné le nom de la personne à prévenir en cas d'accident.");
        }

        if (Form::get('ACCPRENOM') == "") {
            $e->error(6, 1, "Vous n'avez pas enseigné le prénom de la personne à prévenir en cas d'accident.");
        }

        $tel = Form::get('ACCTELFIX');
        if ($tel != '') {
            if (($res = self::verifTel($tel)) == false) {
                $e->error(6, 1, "Le téléphone fixe de la personne à prévenir en cas d'accident est incorrect.");
            } else {
                Form::set('ACCTELFIX', $res);
            }
        }

        $tel = Form::get('ACCTELPORT');
        if ($tel != '') {
            if (($res = self::verifTel($tel)) == false) {
                $e->error(6, 1, "Le téléphone portable de la personne à prévenir en cas d'accident est incorrect.");
            } else {
                Form::set('ACCTELPORT', $res);
            }
        }

        if ((Form::get('ACCTELFIX') == "") && (Form::get('ACCTELPORT') == "")) {
            $e->error(6, 1, "Au moins un téléphone d'une personne à prévenir en cas d'accident doit être renseigné.");
        }
    }

    /**
     * Vérification des champs de saisie du certificat médical
     * @param Error $e
     * @throws \Exception
     */
    private static function checkDcertif(Error $e)
    {
        $dc = Form::get('DATECERTIF');

        if ($dc != "") {
            // verifier date certif

            switch (GucDate::verifDate($dc)) {
                case -1:
                    $e->error(6, 2, "Votre date de certificat est incorrecte (1).");
                    break;
                case -2:
                    $e->error(6, 2, "Votre date de certificat est incorrecte (2).");
                    break;
                case -3:
                case 0:
                    $today = new DateTime();
                    $certif = new DateTime($dc);
                    $expir = $certif->add(new DateInterval('P365D'));
                    $diff = $expir->diff($today);
                    $day = $diff->format('%a');
                    if ($day < 40) {
                        $e->error(6, 2, "Votre certificat médical est trop vieux.");
                    }
                    break;
            }
        } //else
        //Error(5,2,"Vous n'avez pas renseigné la date de certificat médical, ".
        //          "il faudra en amener un le jour de la remise du dossier",false);
    }

    /**
     * Vérification du champ de saisie de l'allergie à l'aspirine
     * @param Error $e
     */
    private static function checkAspi(Error $e)
    {
        if (Form::get('ALERGASP') == "") {
            $e->error(6, 3, "Vous n'avez pas précisé votre intolérance à l'aspirine.");
        }
    }

    /**
     * Vérification du champ de saisie licence FFESSM
     * @param Error $e
     */
    private static function checkLic(Error $e)
    {
        // Calcul Licence

        $age_today = GucDate::age(Form::get('DATENAISS'));

        $cotis = new Calculate();
        $licence = $cotis->calcCotis($_POST);

        if ($licence['fErr']) {
            $e->error(7, 1, "Erreur, calcul licence  impossible, revérifiez votre saisie (2)");
        } else {
            Form::set('LICENCE', $licence);
        }

        if (Form::get('LICENCE') == "") {
            $e->error(7, 1, "Vous n'avez pas renseigné le type de licence FFESSM souhaité.");
        }

        if (Form::get('LICENCE') == FormConst::LIC_ENFANT && $age_today >= 12) {
            $e->error(7, 1, "Vous êtes trop âgé (" . $age_today . " ans) pour prendre cette licence.");
        }

        if (Form::get('LICENCE') == FormConst::LIC_JUNIOR && $age_today >= 16) {
            $e->error(7, 1, "Vous êtes trop âgé (" . $age_today . " ans) pour prendre cette licence.");
        }

        if (Form::get('LICENCE') == FormConst::LIC_JUNIOR && $age_today < 12) {
            $e->error(7, 1, "Vous êtes trop jeune (" . $age_today . " ans) pour prendre cette licence.");
        }

        if (Form::get('LICENCE') == FormConst::LIC_ADULTE && $age_today < 16) {
            $e->error(7, 1, "Vous êtes trop jeune (" . $age_today . " ans) pour prendre cette licence.");
        }
    }

    /**
     * Vérification des champs de saisie AXA
     * @param Error $e
     */
    private static function checkAss(Error $e)
    {
        $assurance = Form::get('ASSURANCE');

        if ($assurance == "") {
            $e->error(8, 1, "Vous n'avez pas précisé l'assurance personnelle que vous souhaitez.");
        }

        if ($assurance != FormConst::A_NONE && Form::get('LICENCE') == FormConst::LIC_AUTRE_CLUB) {
            $e->error(8, 1, "Pour prendre une assurance, contactez le club qui vous a délivré votre licence.");
        }

        $k = new Calculate();
        $axa = $k->calcAxa($assurance);
        if ($axa < 0) {
            $e->error(8, 1, "Erreur de calcul assurance.");
        }
    }

    /**
     * Vérification du champ "réduction famille"
     * @param Error $e
     */
    private static function checkReducfam(Error $e)
    {
        $reducFam = Form::get('REDUCFAM');

        if ($reducFam != '') {
            if (Form::get('BENEVOLE') == 'OUI' ||
                Form::get('ACTIVITE') == FormConst::A_ENCADREMENT ||
                Form::get('COTISATION') == FormConst::COT_APNEE) {
                $e->error(9, 1, "La réduction famille n'est pas compatible avec votre cotisation.");
            }

            $calc = new Calculate();
            $res = $calc->calcReducFam($reducFam, Form::get('REDUCFAMID'));

            if (($res['fErr'] != Calculate::OK) &&
                ($res['fErr'] != Calculate::ID_VIDE)) {
                $e->error(
                    9,
                    1,
                    "Erreur sur l'identifiant de réduction famille, vérifiez votre saisie"
                );
            }
        }
    }

    /**
     * Vérification du champ "prêt de matériel"
     * @param Error $e
     */
    private static function checkPret(Error $e)
    {
        if (Form::get('PRETMAT') == "") {
            $e->error(10, 2, "Vous n'avez pas précisé si vous voulez emprunter du matériel.");
        }

        if (Form::get('PRETMAT') == "OUI" &&
            (Form::get('ACTIVITE') == FormConst::A_APNEEDEB ||
             Form::get('ACTIVITE') == FormConst::A_APNEECONF) &&
            !Form::get('APNEESCA')) {
            $e->error(10, 2, "Vous ne pouvez pas emprunter de matériel avec la cotisation GUC choisie.");
        }
    }

    /**
     * Vérification du champ de saisie d'autorisation d'utilisation de l'adresse mail
     * @param Error $e
     */
    private static function checkMailliste(Error $e)
    {
        if (Form::get('MAILGUC') == "") {
            $e->error(11, 1, "Vous n'avez pas précisé si vous voulez communiquer votre email au GUC Central.");
        }
    }

    /**
     * Vérification du champ de saisie règlement accepté
     * @param Error $e
     */
    private static function checkReglement(Error $e)
    {
        if (Form::get('REGLEMENT') != "OUI" && !Session::isInscriptionModeToOther()) {
            $e->error(
                11,
                2,
                "Vous n'avez pas accepté le règlement intérieur ".
                         "et/ou la politique de protection des données personelles."
            );
        }
    }

    /**
     * Vérification du champ de saisie autorisation parentale
     * @param Error $e
     */
    private static function checkMineur(Error $e)
    {
        $age_today = GucDate::age(Form::get('DATENAISS'));

        if ($age_today < 18) {
            if (Form::get('MINNOM') == "") {
                $e->error(12, 1, "Vous êtes mineur et le nom du représentant légal n'est pas renseigné.");
            }

            if (Form::get('MINPRENOM') == "") {
                $e->error(12, 1, "Vous êtes mineur et le prénom du représentant légal n'est pas renseigné.");
            }

            if (Form::get('MINQUAL') == "") {
                $e->error(12, 1, "Vous êtes mineur et la qualité du représentant légal n'est pas renseignée.");
            }

            if (Form::get('MINSIGN') != "OUI" && !Session::isInscriptionModeToOther()) {
                $e->error(12, 1, "Vous êtes mineur et le document n'est pas signé par le représentant légal .");
            }
        }

        // Inhibition des valeurs saisies dans la section autorisation parentale
        // Si l(adhérent est majeur

        if ($age_today >= 18) {
            Form::set('MINNOM', "");
            Form::set('MINPRENOM', "");
            Form::set('MINQUAL', "");
        }
    }

    /**
     * Fonction d'execution des routine de vérification des champs et informations
     * en fonction du type de licence
     * @param Adherent $user
     * @param ExecutionContextInterface $context
     * @param $payload
     */
    public static function validate(Adherent $user, ExecutionContextInterface $context, $payload): void
    {
        if ($user->getInscrType() == FormConst::REGISTER) {
            return;
        }

        foreach (self::$fields as $v) {
            $func = $v['check'];
            if ($func != null) {
                $class=get_class();
                $func = $class.'::'.$func;
                $func($user, $context);
            }
        }
    }
}
