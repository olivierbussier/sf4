<?php

namespace App\Classes\Inscription;

use App\Classes\Config\Config;
use App\Classes\Form\FormConst;
use App\Entity\Adherent;
use DateTime;

use Doctrine\ORM\EntityManagerInterface;

class Calculate
{

    public const OK           = 0;
    public const DEJA_UTILISE = 1;
    public const ADH_INCONNU  = 2;
    public const ID_ERROR     = 3;
    public const ID_PERSONEL  = 4;
    public const ID_VIDE      = 5;

    /**
     * Calculate constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct()
    {
    }

    /**
     * Retourne la différence entre deux dates exprimé en années sous forme d'entier
     * @param DateTime $dateOld
     * @param DateTime $dateNew
     * @return int
     */
    public function dateDiff(DateTime $dateOld, DateTime $dateNew): int
    {
        return $dateNew->diff($dateOld)->y;
    }

    /**
     * Calcul de la réduction famille en fonction de l'identifiant famille passé en paramètre.
     * @param $val string l'identifiant reduction famille à vérifier
     * @param string $reducID l'ID de la personne demandant une réduction famille
     * @return array
     */
    public function calcReducFam(?string $val, ?string $reducID)
    {
        if ($val == '') {
            $ret['fErr'] = self::ID_VIDE;
            $ret['msg'] = '';
        } else {
            if ((AdhCoding::checkValID($val)) != false) {
                // Vérifier que ce n'est pas son propre ID

                if ($val == $reducID) {
                    $ret['fErr'] = self::ID_PERSONEL;
                    $ret['msg'] = '';
                } else {
                    // Valide, Vérification que ce numéro n'est pas déja utilisé pour
                    // valider d'autres réductions famille

                    $adhRepo = $this->em->getRepository('Adherent');
                    $id = $adhRepo->findBy(['ReducFamId' => $val]);
/*
                    $db = Globals::getDb();

                    $res = $db->query("select NOM,PRENOM,REDUCFAM,ADMINOK from @#@liste ".
                                        "where LOWER(REDUCFAMID)='$val' and ADMINOK <> ''");
*/
                    if ($id) {/*
                        // L'adhérent existe et est inscrit ou en cours d'inscription

                        if ($d['REDUCFAM'] != '') {
                            $ret['fErr'] = self::DEJA_UTILISE;
                            $ret['msg'] = '';
                        } else {
                            $ret['fErr'] = self::OK;
                            $ret['msg'] = $d['PRENOM'] . ' ' . $d['NOM'];
                        }*/
                    } else {
                        $ret['fErr'] = self::ADH_INCONNU;
                        $ret['msg'] = '';
                    }
                }
            } else {
                $ret['fErr'] = self::ID_ERROR;
                $ret['msg'] = '';
            }
        }
        return $ret;
    }

    /**
     * @param array $tab
     * @param string $var
     * @return bool
     */
    private function isSet(array $tab, string $var)
    {
        if (isset($tab[$var]) && $tab[$var] == 'OUI') {
            return true;
        } else {
            return false;
        }
    }

    private function testFlag($val,$elem)
    {
        if (isset($val[$elem]) && $val[$elem] == true) {
            return true;
        } else {
            return false;
        }
    }
    private function testVal($val,$elem)
    {
        if (isset($val[$elem])) {
            return $val[$elem];
        } else {
            return '';
        }
    }
    /**
     * Calcul de la cotisation club basé sur les valeurs du tableau passé en parametre. Ce tableau a les meme noms de
     * champs que $_POST issu du formulaire d'inscription
     * @param Adherent $user
     * @return array
     */
    public function calcCotis($post): array
    {
        if ($post instanceof Adherent) {
            $benevole =  $post->getFBenevole();
            $familleID=  $post->getReducFamilleID();
            $famille  =  $post->getReducFam();
            $etudiant =  $post->getFEtudiant();
            $apneesca =  $post->getFApneeSca();
            $flicence =  $post->getLicence() == 'Autre Club';
            $caesug   =  $post->getFacture() == 'CAESUG';
            $niveau   =  $post->getNiveauSca();
            $apnee    =  $post->getNiveauApn();
            $activite =  $post->getActivite();
            $datenaiss=  $post->getDateNaissance()->format('d/m/Y');
            $mode     =  $post->getInscrType();
        } else {
            $benevole =  $this->testFlag($post,'fBenevole');
            $familleID=  $this->testVal($post,'ReducFamID');
            $famille  =  $post['ReducFam'];
            $etudiant =  $this->testFlag($post,'fEtudiant');
            $apneesca =  $this->testFlag($post,'fApneeSca');
            $flicence =  $post['Licence'] == 'Autre Club';
            $caesug   =  $post['Facture'] == 'CAESUG';
            $niveau   =  $post['NiveauSca'];
            $apnee    =  $post['NiveauApn'];
            $activite =  $post['Activite'];
            $datenaiss=  $post['DateNaissance'];
            $mode     =  $post['InscrType'];

        }

        return $this->adaptPrix(
            $niveau,
            $apnee,
            $activite,
            $datenaiss,
            $benevole,
            $etudiant,
            $famille,
            $familleID,
            $apneesca,
            $flicence,
            $caesug,
            $mode
        );
    }

    /**
     * Calcul cotisation, assurance et cheques à partir des variables de formulaires
     * @param int $Ref
     * @return mixed
     */
    public function calcFees(int $Ref = 0)
    {

        // Si $Ref == 0 cela veut dire qu'on utilise les données déjà dans les structures de dataform
        // Sinon, on charge avec les données de l'adhérent dont la RefUser est $Ref
/*
        if ($Ref != 0) {
            $db = Globals::getDb();
            $res = $db->query("select * from @#@liste where Ref = '".$Ref."'");
            $data = $db->nextrow($res);
            Form::Initialise($data);
        }

        $fLicence = Form::get('LICENCE') == FormConst::LIC_AUTRE_CLUB;
        $fCaesug  = Form::get('FACTURE') == "CAESUG";
        $dnaiss   = Form::get('DATENAISS');

        if (!$fLicence) {
            $myAssur = $this->calcAxa(Form::get('ASSURANCE'));
        } else {
            $myAssur = [
                'fErr'    => false,
                'typeAxa' => 'Autre Club',
                'prixAxa' => 0
                ];
        }
        $myCotis = $this->adaptPrix(
            Form::get('NIVEAU'),
            Form::get('APNEE'),
            Form::get('ACTIVITE'),
            $dnaiss,
            Form::get('BENEVOLE') == 'OUI',
            Form::get('ETUDIANT') == 'OUI',
            Form::get('REDUCFAM'),
            Form::get('REDUCFAMID'),
            Form::get('APNEESCA') == 'OUI',
            $fLicence,
            $fCaesug
        );

        $ret['licence' ] = $myCotis;
        $ret['assur'   ] = $myAssur;
*/
$ret = 1;
        return $ret;
    }

    /**
     * @param DateTime $dNaiss
     * @param bool $fLic Vaut 'true' si l'adhérent à pris sa licence dans un autre club
     * @return array
     */
    public function calcLicence(DateTime $dNaiss, bool $fLic): array
    {
        $ageToday = $this->dateDiff($dNaiss, new DateTime('now'));
        $ret = [];

        $ret['fErr'] = false;
        if ($fLic) {
            // Autre club
            $ret['typeLicence' ] = FormConst::LIC_AUTRE_CLUB;
            $ret['prixLicence'] = 0;
        } elseif ($ageToday < 12) {
            $ret['typeLicence' ] = FormConst::LIC_ENFANT;
            $ret['prixLicence'] = Config::LICENCE_12;
        } elseif ($ageToday >= 12 && $ageToday < 16) {
            $ret['typeLicence' ] = FormConst::LIC_JUNIOR;
            $ret['prixLicence'] = Config::LICENCE12_16;
        } elseif ($ageToday >= 16) {
            $ret['typeLicence' ] = FormConst::LIC_ADULTE;
            $ret['prixLicence'] = Config::LICENCE_ADUL;
        } else {
            $ret['fErr'] = true;
            $ret['typeLicence' ] = '';
            $ret['prixLicence'] = 0;
        }
        return $ret;
    }

    /**
     * @param string $nivSca
     * @param string $nivApnee
     * @param string $activite
     * @param string $dNaiss
     * @param bool $fBene
     * @param bool $fEtud
     * @param string $famille
     * @param string $familleID
     * @param bool $fApneeSca
     * @param bool $fLic
     * @param bool $fCAESUG
     * @param int $mode
     * @return array
     */
    public function adaptPrix(
        ?string $nivSca,
        ?string $nivApnee,
        ?string $activite,
        ?string $dNaiss,
        ?bool $fBene,
        ?bool $fEtud,
        ?string $famille,
        ?string $familleID,
        ?bool $fApneeSca,
        ?bool $fLic,
        ?bool $fCAESUG,
        ?int  $mode = FormConst::INSCR_NORMAL
    ): array {
        $fErreur = false;

        if ($dNaiss == '') {
            $ret['typeCotis'] = "ERR";
            $ret['prixCotis'] = 0;
            $ret['fErr' ] = true;
            //$fErreur = true;
            return $ret;
        }

        $fEnc = false;
        $dateNaiss = new DateTime($dNaiss);
        $ageFinAnnee = $this->dateDiff($dateNaiss, (new DateTime(Config::$p_annee . "-12-31")));

        $lic = $this->calcLicence($dateNaiss, $fLic);
        $ret['typeLicence'] = $lic['typeLicence'];
        $ret['prixLicence'] = $lic['prixLicence'];

        if ($mode == FormConst::INSCR_NORMAL) {
            $rFamille = $this->calcReducFam($famille, $familleID);

            if ($rFamille['fErr'] == Calculate::OK) {
                $fFamille = true;
            } else {
                $fFamille = false;
            }

            if ((in_array($nivSca, FormConst::NIVEAUX_ENCADRANTS) ||
                 in_array($nivApnee, FormConst::NIVEAUX_ENCADRANTS)) &&
                !in_array($activite, FormConst::A_PROGRESSION)) {
                $fEnc = true;
                $ret['typeCotis'] = '(Encadrant)';
            }

            if ($fEnc || $fBene) {
                $ret['typeCotis'] = FormConst::COT_BENEVOLE;
                $ret['prixCotis'] = Config::CLUB_BENE;
            } elseif ($activite == FormConst::A_APNEEDEB || $activite == FormConst::A_APNEECONF) {
                if ($fApneeSca) {
                    $ret['typeCotis'] = FormConst::COT_APNEESCA;
                    $ret['prixCotis'] = Config::CLUB_APN1;
                } else {
                    $ret['typeCotis'] = FormConst::COT_APNEE;
                    $ret['prixCotis'] = Config::CLUB_APN2;
                }
            } elseif (($ageFinAnnee < 25 && $fEtud) || $ageFinAnnee < 18) {
                $ret['typeCotis'] = FormConst::COT_ENFANTS;
                $ret['prixCotis'] = Config::CLUB_JEUN;
            } elseif ($nivSca == FormConst::N_DEBUT && $activite == FormConst::A_PN1) {
                $ret['typeCotis'] = FormConst::COT_DEBUTANT;
                $ret['prixCotis'] = Config::CLUB_DEBU;
            } elseif ($activite == FormConst::A_MAINTIEN || $activite == FormConst::A_PERFPMT) {
                $ret['typeCotis'] = FormConst::COT_MAINTIEN;
                $ret['prixCotis'] = Config::CLUB_MAIN;
            } elseif ($nivSca != FormConst::N_DEBUT && in_array($activite, FormConst::A_PROGRESSION)) {
                $ret['typeCotis'] = FormConst::COT_PROGRESS;
                $ret['prixCotis'] = Config::CLUB_AUTR;
            } else {
                $ret['typeCotis'] = "ERR";
                $ret['prixCotis'] = 0;
                $ret['fErr' ] = true;
                $fErreur = true;
            }

            if (!$fErreur) {
                $ret['typeReduc'] = 'Aucune';
                $ret['prixReduc'] = 0;
                $ret['typeRemb'] = 'Aucun';
                $ret['prixRemb'] = 0;
                // Réduc famille
                if ($fFamille && $ret['prixCotis'] > 50) {
                    $ret['typeReduc'] = "réduction famille";
                    $ret['prixReduc'] = Config::REDUC_FAMILLE;
                }
                if ($fCAESUG) {
                    $ret['typeRemb'] = "prise en charge CAESUG";
                    // Reduction famille enlevée de la prise en charge CAESUG
                    $ret['prixRemb'] = $ret['prixCotis'] - $ret['prixReduc'];
                }
                $ret['prixCotis'] += Config::SIUAPS;
                $ret['prixCotis'] += Config::CARTE_GUC;

                $ret['prixTotal'] = 0;
                $ret['prixCaesug'] = 0;
                if (!$fErreur) {
                    // Calcul du prix de la cotisation
                    $ret['prixTotal'] = $ret['prixCotis'] - $ret['prixReduc']; // Cotisation
                    $ret['prixCaesug'] = $ret['prixRemb'];
                }
                $ret['fBene'] = $fBene;
                $ret['fEnc'] = $fEnc;
                $ret['fErr'] = $fErreur;
            }
        } else {
            //$ret['prixTotal'] = $ret['prixLicence'];
            $ret['fErr'] = false;
/*
            $ret['typeReduc']  = 'Aucune';
            $ret['prixReduc']  = 0;

            $ret['typeRemb']   = 'Aucun';
            $ret['prixRemb']   = 0;

            $ret['prixCaesug'] = 0;

            $ret['typeCotis']  = 'Aucune';
            $ret['prixCotis']  = 0;
*/
        }
        return $ret;
    }

    /**
     * @param string $assurance
     * @return array
     */
    public function calcAxa(string $assurance): array
    {

        switch ($assurance) {
            case FormConst::A_L1B : $axa = Config::AXA_L1B; break;
            case FormConst::A_L2B : $axa = Config::AXA_L2B; break;
            case FormConst::A_L3B : $axa = Config::AXA_L3B; break;
            case FormConst::A_L1T : $axa = Config::AXA_L1T; break;
            case FormConst::A_L2T : $axa = Config::AXA_L2T; break;
            case FormConst::A_L3T : $axa = Config::AXA_L3T; break;
            case FormConst::A_PIS : $axa = Config::AXA_PIS; break;
            case FormConst::A_NONE: $axa = 0;               break;
            default:                 $axa = -1;              break;
        }
        if ($axa == -1) {
            $ret['fErr'] = true;
            $ret['typeAxa'] = '';
            $ret['prixAxa'] = 0;
        } else {
            $ret['fErr'] = false;
            $ret['typeAxa'] = $assurance;
            $ret['prixAxa'] = $axa;
        }
        return $ret;
    }
}
