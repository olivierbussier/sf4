<?php

namespace App\Bundles\Validator;

use App\Classes\Config\Config;
use App\Classes\Helpers\DateHelper;
use App\Classes\Form\FormConst;
use App\Classes\Helpers\FileHelper;
use App\Classes\Inscription\Calculate;
use App\Entity\Adherent;
use App\Entity\Diplome;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AdherentClassValidator extends ConstraintValidator
{
    /**
     * @var string fonction Javascript appelée lorsque le contenu d'un champ change
     */
    private $requestStack;
    private $em;

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
    private $fields = [
        [FormConst::INSCR_PASSAGER => true,  FormConst::INSCR_NORMAL => true,  'check' => 'checkAddress'],
        [FormConst::INSCR_PASSAGER => true,  FormConst::INSCR_NORMAL => true,  'check' => 'checkProf'],
        [FormConst::INSCR_PASSAGER => true,  FormConst::INSCR_NORMAL => true,  'check' => 'checkDnaiss'],
        [FormConst::INSCR_PASSAGER => false, FormConst::INSCR_NORMAL => true,  'check' => 'checkTel'],
        [FormConst::INSCR_PASSAGER => true,  FormConst::INSCR_NORMAL => true,  'check' => 'checkNiv'],
        [FormConst::INSCR_PASSAGER => false, FormConst::INSCR_NORMAL => true,  'check' => 'checkDipl'],
        [FormConst::INSCR_PASSAGER => false, FormConst::INSCR_NORMAL => true,  'check' => 'checkActi'],
        [FormConst::INSCR_PASSAGER => false, FormConst::INSCR_NORMAL => true,  'check' => 'checkAcci'],
        [FormConst::INSCR_PASSAGER => false, FormConst::INSCR_NORMAL => true,  'check' => 'checkAspi'],
        [FormConst::INSCR_PASSAGER => true,  FormConst::INSCR_NORMAL => true,  'check' => 'checkDcertif'],
        [FormConst::INSCR_PASSAGER => false, FormConst::INSCR_NORMAL => true,  'check' => 'checkLic'],
        [FormConst::INSCR_PASSAGER => true,  FormConst::INSCR_NORMAL => true,  'check' => 'checkAss'],
        [FormConst::INSCR_PASSAGER => false, FormConst::INSCR_NORMAL => true,  'check' => 'checkReducfam'],
        [FormConst::INSCR_PASSAGER => false, FormConst::INSCR_NORMAL => true,  'check' => 'checkPret'],
        [FormConst::INSCR_PASSAGER => true,  FormConst::INSCR_NORMAL => true,  'check' => 'checkMailliste']/*,
        [FormConst::INSCR_PASSAGER => false, FormConst::INSCR_NORMAL => true,  'check' => 'checkReglement'],
        [FormConst::INSCR_PASSAGER => false, FormConst::INSCR_NORMAL => true,  'check' => 'checkMineur'],
        [FormConst::INSCR_PASSAGER => false, FormConst::INSCR_NORMAL => true,  'check' => 'checkPhoto']*/
    ];

    public function __construct(RequestStack $requestStack, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->requestStack = $requestStack;
    }

    private function e($text, $var)
    {
        $this->context->buildViolation($text)
            ->atPath($var)
            ->addViolation();

    }

    /**
     * Vérification des champs d'adresse
     * @param Adherent $user
     */
    private function checkAddress(Adherent $user)
    {
        // *********************************************************************
        // verifier addresse != 0
        // *********************************************************************
        if ($user->getAdresse1() == "") {
            $this->e("Vous n'avez pas mis votre adresse.", 'Adresse1');
        }

        // *********************************************************************
        // verifier code postal = 5 chiffres
        // *********************************************************************
        $codep = $user->getCodePostal();
        if (!preg_match('/[0-9][0-9][0-9][0-9][0-9]/', $codep) || (strlen($codep) != 5)) {
           $this->e("Votre code postal est incorrect.", 'CodePostal');
        }

        // *********************************************************************
        // verifier ville != 0
        // *********************************************************************
        if ($user->getVille() == "") {
            $this->e("Vous n'avez pas mis votre ville.", 'Ville');
        }
    }

    /**
     * Vérification de la saisie du champ profession
     * @param Adherent $user
     */
    private function checkProf(Adherent $user)
    {
        if ($user->getProfession() == "") {
            $this->e("Vous n'avez pas mis votre profession.", 'Profession');
        }
    }

    /**
     * Fonction de check de la date de naissance
     * @param Adherent $user
     * @throws \Exception
     */
    private function checkDnaiss(Adherent $user)
    {
        // *********************************************************************
        // calcul de l'âge
        // *********************************************************************
        // Deux 'ages' à predre en compte:
        // - L'age au moment de l'inscription
        // - L'age après le 31/12 de l'année
        // *********************************************************************

        // Vérification de la date

        $dnaiss = $user->getDateNaissance();

        if ($dnaiss != null) {
            $datenaiss = $dnaiss->format('d/m/Y');

            switch (DateHelper::verifDate($datenaiss)) {
                case -1:
                    $this->e("Votre date de naissance est incorrecte ($datenaiss).", 'DateNaissance');
                    break;
                case -2:
                    $this->e("Votre date de naissance est incorrecte (2) ($datenaiss).", 'DateNaissance');
                    break;
                case -3:
                    $this->e("L'année de naissance est incorrecte.", 'DateNaissance');
                    break;
                case -4:
                    $this->e("L'année de naissance est incorrecte (3).", 'DateNaissance');
                    break;
                case 0:
                    break; // Pas d'erreur
            }

            $age_finannee = DateHelper::age($datenaiss, "31/12/" . Config::p_annee);

            if ($age_finannee < 10) {
                $this->e("Il est nécessaire d'avoir 10ans révolus au 01/01/" . (Config::p_annee + 1) .
                    " pour prendre une licence FFESSM et/ou vous inscrire au club.", 'DateNaissance');
            }
        } else {
            $this->e("L'année de naissance n'est pas renseignée.", 'DateNaissance');
        }
    }

    /**
     * Helper de vérification des numéros de téléphone
     * @param $str
     * @return bool|null|string|string[]
     */
    private function verifTel($str)
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
     */
    private function checkTel(Adherent $user)
    {
        $tel = $user->getTelFix();

        if ($tel != '') {
            if (($res = self::verifTel($tel)) == false) {
                $this->e("Votre numéro de téléphone fixe est incorrect.", 'TelFix');
            } else {
                $user->setTelFix($res);
            }
        }

        $tel = $user->getTelPort();
        if ($tel != '') {
            if (($res = self::verifTel($tel)) == false) {
                $this->e("Votre numéro de téléphone portable est incorrect.", 'TelPort');
            } else {
                $user->setTelPort($res);
            }
        }

        if (($user->getTelFix() == "") && ($user->getTelPort() == "")) {
            $this->e("Au moins un téléphone doit être renseigné.", 'TelFix');
        }
    }

    /**
     * Vérification photo
     * @param Adherent $user
     */
    private function checkPhoto(Adherent $user)
    {
        $NOM    = $user->getNom();
        $PRENOM = $user->getPrenom();
        $REFUSR = $user->getId();

        $path = FileHelper::initPathPhoto($NOM, $PRENOM, $REFUSR, FileHelper::THUMBNAIL);

        // Vérification de l'existence de l'image

        if (!file_exists($path)) {
            $this->e("Votre photo d'identité est manquante.", 'Photo');
        }
    }

    /**
     * Vérification de la saisie des niveaux
     * @param Adherent $user
     * @throws \Exception
     */
    private function checkNiv(Adherent $user)
    {
        $Niveau = $user->getNiveauSca();
        $Apnee = $user->getNiveauApn();
        $dnaiss = $user->getDateNaissance()->format('d/m/Y');

        $age_finannee = DateHelper::age($dnaiss, "31/12/" . Config::p_annee);

        if ($Niveau == "") {
            $this->e("Vous n'avez pas renseigné votre niveau actuel de plongée scaphandre.", 'NiveauSca');
        } else {
            if ($age_finannee < 13 && $Niveau != "Enfant") {
                $this->e("Agé de " . $age_finannee . " ans au 31/12/" . Config::p_annee .
                    " et à moins de 14 ans, vous devez cocher enfant.", 'NiveauSca');
            }

            if ($age_finannee >= 14 && $Niveau == "Enfant") {
                $this->e("Agé de " . $age_finannee . " ans au 01/01/" . (Config::p_annee + 1) .
                    " et à partir de 14 ans, vous n'êtes plus considéré comme un enfant pour la FFESSM.", 'NiveauSca');
            }
        }

        if ($Apnee == "") {
            $this->e("Vous n'avez pas renseigné votre niveau actuel d'apnée.", 'NiveauApn');
        }
    }

    /**
     * Vérification des champs de saisie des diplômes
     * @param Adherent $user
     * @throws \Exception
     */
    private function checkDipl(Adherent $user)
    {
        $dnaiss = $user->getDateNaissance()->format('d/m/Y');
        $age_today = DateHelper::age($dnaiss);
        $Niveau = $user->getNiveauSca();

        $diplomes = $user->getDiplomes();

        /** @var Diplome $diplome */
        foreach ($diplomes as $diplome) {

            switch ($diplome) {
                case 'TIV':
                    if ($age_today < 18) {
                        $this->e("Vous avez " . $age_today .
                            " ans et TIV implique que vous êtes majeur, vérifiez votre date de naissance.", 'Diplomes');
                    }
                    if ($Niveau == "Débutant" || $Niveau == "N1" || $Niveau == "Enfant") {
                        $this->e("TIV implique que vous êtes au moins Niveau 2.", 'Diplomes');
                    }
                    break;
            }
        }
    }

    /**
     * Vérification des champs de saisie d'activité
     * @param Adherent $user
     * @throws \Exception
     */
    private function checkActi(Adherent $user)
    {
        $Niveau   = $user->getNiveauSca();
        $Apnee    = $user->getNiveauApn();
        $Activite = $user->getActivite();
        $dnaiss   = $user->getDateNaissance()->format('d/m/Y');

        $age_today    = DateHelper::age($dnaiss);
        $age_finannee = DateHelper::age($dnaiss, "31/12/" . Config::p_annee);

        if ($Activite == "") {
            $this->e("Vous n'avez pas renseigné votre activité pour cette année.", 'Activite');
        }

        if (($Activite == FormConst::A_ENFANTS) && ($Niveau != FormConst::N_ENFANT)) {
            $this->e("Votre activité est incompatible avec votre niveau de plongée.", 'Activite');
        }

        if ($age_finannee >= 14 && $Activite == FormConst::A_ENFANTS) {
            $this->e("Vous êtes trop âgé  (" . $age_today . " ans) pour la section enfants.",'Activite');
        }

        if (($Activite == FormConst::A_PN1) &&
            ($Niveau   != FormConst::N_ENFANT) &&
            ($Niveau   != FormConst::N_DEBUT) &&
            ($Niveau   != FormConst::N_OWD)) {
            $this->e("Votre activité est incompatible avec votre niveau de plongée.",'Activite');
        }

        if (($Activite == FormConst::A_PN2) &&
            ($Niveau   != FormConst::N_N1) &&
            ($Niveau   != FormConst::N_PA2) &&
            ($Niveau   != FormConst::N_PE4) &&
            ($Niveau   != FormConst::N_OWD) &&
            ($Niveau   != FormConst::N_AOWD)) {
            $this->e("Votre activité est incompatible avec votre niveau de plongée.",'Activite');
        }

        if (($Activite == FormConst::A_PE4) &&
            ($Niveau   != FormConst::N_N1) &&
            ($Niveau   != FormConst::N_PA2) &&
            ($Niveau   != FormConst::N_OWD) &&
            ($Niveau   != FormConst::N_AOWD)) {
            $this->e("Votre activité est incompatible avec votre niveau de plongée.", 'Activite');
        }

        if (($Activite == FormConst::A_PN3) &&
            ($Niveau   != FormConst::N_PA4) &&
            ($Niveau   != FormConst::N_N2) &&
            ($Niveau   != FormConst::N_N2I) &&
            ($Niveau   != FormConst::N_RDMD)) {
            $this->e("Votre activité est incompatible avec votre niveau de plongée.",'Activite');
        }

        if ($Activite == FormConst::A_PN4) {
            if (($Niveau != FormConst::N_N3) &&
                ($Niveau != FormConst::N_N3I)) {
                $this->e("Votre activité est incompatible avec votre niveau de plongée.",'Activite');
            }
        }

        if ($Activite == FormConst::A_PINITIATEUR) {
            if (($Niveau != FormConst::N_N2) &&
                ($Niveau != FormConst::N_N3) &&
                ($Niveau != FormConst::N_N4)) {
                $this->e("Votre activité est incompatible avec votre niveau de plongée.", 'Activite');
            }
        }

        if ($Activite == FormConst::A_PMF1) {
            if (($Niveau != FormConst::N_N4) &&
                ($Niveau != FormConst::N_N4I)) {
                $this->e("Votre activité est incompatible avec votre niveau de plongée.", 'Activite');
            }
        }

        if ($Activite == FormConst::A_ENCADREMENT) {
            if (($Niveau != FormConst::N_N2I)  && ($Niveau != FormConst::N_N3I) &&
                ($Niveau != FormConst::N_N4)   && ($Niveau != FormConst::N_N4I) &&
                ($Niveau != FormConst::N_MF1)  && ($Niveau != FormConst::N_MF2) &&
                ($Apnee  != FormConst::N_A2I)  && ($Apnee  != FormConst::N_A3I) &&
                ($Apnee  != FormConst::N_A4)   && ($Apnee  != FormConst::N_A4I) &&
                ($Apnee  != FormConst::N_MEF1) && ($Apnee  != FormConst::N_MEF2)) {
                $this->e("Pour encadrer, vous devez avoir un diplôme d'encadrant.", 'Activite');
            }
        }

        // Calcul Cotisation

        $cal = new Calculate();
        $ret = $cal->calcCotis($user);

        if ($ret['fErr']) {
            $this->e("Erreur, calcul cotisation impossible, revérifiez votre saisie (1)", 'Cotisation');
        } else {
            $user->setCotisation($ret['typeCotis']);
        }

        if ($user->getCotisation() == FormConst::COT_ENFANTS && $age_finannee >= 25) {
            $this->e("Vous devez être agé de moins de 18 ans ou " .
                "être étudiant de moins de 25 ans pour prendre cette cotisation.", 'Cotisation');
        }

        if ($user->getCotisation() == FormConst::COT_ENFANTS && $age_finannee >= 18 && !$user->getFEtudiant()) {
            $this->e("Vous devez être agé de moins de 18 ans ou " .
                "être étudiant de moins de 25 ans pour prendre cette cotisation.", 'Cotisation');
        }
    }

    /**
     * Vérification des champs de saisie de la personne à prevenir en cas d'accident
     * @param Adherent $user
     */
    private function checkAcci(Adherent $user)
    {
        if ($user->getAccidentNom() == "") {
            $this->e("Vous n'avez pas renseigné le nom de la personne à prévenir en cas d'accident.", 'AccidentNom');
        }

        if ($user->getAccidentPrenom() == "") {
            $this->e("Vous n'avez pas enseigné le prénom de la personne à prévenir en cas d'accident.", 'AccidentPrenom');
        }

        $tel = $user->getAccidentTelFix();
        if ($tel != '') {
            if (($res = self::verifTel($tel)) == false) {
                $this->e("Le téléphone fixe de la personne à prévenir en cas d'accident est incorrect.", 'AccidentTelFix');
            } else {
                $user->setAccidentTelFix($res);
            }
        }

        $tel = $user->getAccidentTelPort();
        if ($tel != '') {
            if (($res = self::verifTel($tel)) == false) {
                $this->e("Le téléphone portable de la personne à prévenir en cas d'accident est incorrect.", 'AccidentTelPort');
            } else {
                $user->setAccidentTelPort($res);
            }
        }

        if (($user->getAccidentTelFix() == "") && ($user->getAccidentTelPort() == "")) {
            $this->e("Au moins un téléphone d'une personne à prévenir en cas d'accident doit être renseigné.",'AccidentTelFix');
        }
    }

    /**
     * Vérification des champs de saisie du certificat médical
     * @param Adherent $user
     * @throws \Exception
     */
    private function checkDcertif(Adherent $user)
    {
        $dcert = $user->getDateCertif();

        if ($dcert != null) {
            $dc = $dcert->format('Y-m-d');

            if ($dc != "") {
                // verifier date certif

                switch (DateHelper::verifDate($dc)) {
                    case -1:
                        $this->e("Votre date de certificat est incorrecte (1).", 'DateCertif');
                        break;
                    case -2:
                        $this->e("Votre date de certificat est incorrecte (2).", 'DateCertif');
                        break;
                    case -3:
                    case 0:
                        $today = new DateTime();
                        $certif = new DateTime($dc);
                        $expir = $certif->add(new DateInterval('P365D'));
                        $diff = $expir->diff($today);
                        $day = $diff->format('%a');
                        if ($day < 40) {
                            $this->e("Votre certificat médical est trop vieux.", 'DateCertif');
                        }
                        break;
                }
            }
        } else {
            $this->e("Votre date de certificat n'est pas renseignée.", 'DateCertif');
        }
    }

    /**
     * Vérification du champ de saisie de l'allergie à l'aspirine
     * @param Adherent $user
     */
    private function checkAspi(Adherent $user)
    {
        if ($user->getFAllergAspirine() == "") {
            $this->e("Vous n'avez pas précisé votre intolérance à l'aspirine.",'fAllergAspirine');
        }
    }

    /**
     * Vérification du champ de saisie licence FFESSM
     * @param Adherent $user
     */
    private function checkLic(Adherent $user)
    {
        // Calcul Licence

        $age_today = DateHelper::age($user->getDateNaissance()->format('Y-m-d'));

        $cotis = new Calculate();
        $licence = $cotis->calcCotis($user);

        if ($licence['fErr']) {
            $this->e("Erreur, calcul licence  impossible, revérifiez votre saisie (2)", 'Licence');
            return;
        } else {
            $lic = $licence['typeLicence'];
            $user->setLicence($lic);
        }

        if ($lic == FormConst::LIC_ENFANT && $age_today >= 12) {
            $this->e("Vous êtes trop âgé (" . $age_today . " ans) pour prendre cette licence.", 'Licence');
        }

        if ($lic == FormConst::LIC_JUNIOR && $age_today >= 16) {
            $this->e("Vous êtes trop âgé (" . $age_today . " ans) pour prendre cette licence.", 'Licence');
        }

        if ($lic == FormConst::LIC_JUNIOR && $age_today < 12) {
            $this->e("Vous êtes trop jeune (" . $age_today . " ans) pour prendre cette licence.", 'Licence');
        }

        if ($lic == FormConst::LIC_ADULTE && $age_today < 16) {
            $this->e("Vous êtes trop jeune (" . $age_today . " ans) pour prendre cette licence.", 'Licence');
        }
    }

    /**
     * Vérification des champs de saisie AXA
     * @param Adherent $user
     */
    private function checkAss(Adherent $user)
    {
        $assurance = $user->getAssurance();

        if ($assurance == "") {
            $this->e("Vous n'avez pas précisé l'assurance personnelle que vous souhaitez.",'Assurance');
        }

        if ($assurance != FormConst::A_NONE && $user->getLicence() == FormConst::LIC_AUTRE_CLUB) {
            $this->e("Pour prendre une assurance, contactez le club qui vous a délivré votre licence.", 'Assurance');
        }

        $k = new Calculate();
        $axa = $k->calcAxa($assurance);
        if ($axa < 0) {
            $this->e("Erreur de calcul assurance.", 'Assurance');
        }
    }

    /**
     * Vérification du champ "réduction famille"
     * @param Adherent $user
     */
    private function checkReducfam(Adherent $user)
    {
        $reducFam = $user->getReducFam();

        if ($reducFam != '') {
            if ($user->getFBenevole() ||
                $user->getActivite() == FormConst::A_ENCADREMENT ||
                $user->getCotisation() == FormConst::COT_APNEE) {
                $this->e("La réduction famille n'est pas compatible avec votre cotisation.", 'ReducFam');
            }

            $calc = new Calculate();
            $res = $calc->calcReducFam($reducFam, $user->getReducFamilleID(),$this->em);

            if (($res['fErr'] != Calculate::OK) &&
                ($res['fErr'] != Calculate::ID_VIDE)) {
                $this->e("Erreur sur l'identifiant de réduction famille, vérifiez votre saisie", 'ReducFam');
            }
        }
    }

    /**
     * Vérification du champ "prêt de matériel"
     * @param Adherent $user
     */
    private function checkPret(Adherent $user)
    {
        if ($user->getPretMateriel() == "") {
            $this->e("Vous n'avez pas précisé si vous voulez emprunter du matériel.", 'PretMateriel');
        }

        if ($user->getPretMateriel() &&
            ($user->getActivite() == FormConst::A_APNEEDEB ||
             $user->getActivite() == FormConst::A_APNEECONF) &&
             !$user->getFApneeSca()) {
            $this->e("Vous ne pouvez pas emprunter de matériel avec la cotisation GUC choisie.", 'PretMateriel');
        }
    }

    /**
     * Vérification du champ de saisie d'autorisation d'utilisation de l'adresse mail
     * @param Adherent $user
     */
    private function checkMailliste(Adherent $user)
    {
        if ($user->getFMailGUC() == "") {
            $this->e("Vous n'avez pas précisé si vous voulez communiquer votre email au GUC Central.", 'fMailGUC');
        }
    }

    /**
     * Vérification du champ de saisie règlement accepté
     * @param Adherent $user
     */
    private function checkReglement(Adherent $user)
    {
        if (!$user->getReglementRGPD() && !Session::isInscriptionModeToOther()) {
            $this->e(

                "Vous n'avez pas accepté le règlement intérieur ".
                "et/ou la politique de protection des données personelles.",
                'ReglementRGPD'
            );
        }
    }

    /**
     * Vérification du champ de saisie autorisation parentale
     * @param Adherent $user
     * @throws \Exception
     */
    private function checkMineur(Adherent $user)
    {
        $age_today = DateHelper::age($user->getDateNaissance());

        if ($age_today < 18) {
            if ($user->getMineurNom() == "") {
                $this->e("Vous êtes mineur et le nom du représentant légal n'est pas renseigné.",'MineurNom');
            }

            if ($user->getMineurPrenom() == "") {
                $this->e("Vous êtes mineur et le prénom du représentant légal n'est pas renseigné.", 'MineurPrenom');
            }

            if ($user->getMineurQualite() == "") {
                $this->e("Vous êtes mineur et la qualité du représentant légal n'est pas renseignée.", 'MineurQualite');
            }

            if (!$user->getMineurSign() && !Session::isInscriptionModeToOther()) {
                $this->e("Vous êtes mineur et le document n'est pas signé par le représentant légal .",'MineurSign');
            }
        }

        // Inhibition des valeurs saisies dans la section autorisation parentale
        // Si l(adhérent est majeur

        if ($age_today >= 18) {
            $user->setMineurNom('');
            $user->setMineurPrenom('');
            $user->setMineurQualite('');
        }
    }

    /**
     * Fonction d'execution des routine de vérification des champs et informations
     * en fonction du type de licence
     * @param $adherent
     * @param Constraint $constraint
     */
    public function validate($adherent, Constraint $constraint): void
    {
        if ($adherent->getInscrType() == FormConst::REGISTER) {
            return;
        }

        foreach ($this->fields as $v) {
            $func = $v['check'];
            if ($func != null) {
                $this->{$func}($adherent, $this->context);
            }
        }
    }
}
