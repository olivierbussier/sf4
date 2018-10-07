<?php

namespace App\Controller\Inscription;

use App\Classes\Form\FormConst;
use App\Classes\Inscription\Calculate;
use App\Entity\Adherent;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController extends Controller
{
    const ITEM = 1;
    const TITR = 2;
    const BADG = 3;
    const BADGV = 4;
    const TEXT = 5;

    /**
     * @param $string
     */
    private function ligne($string)
    {
        echo '<span class="ligneasync">' . $string . '</span>';
    }

    /**
     * @param int $mode
     * @param string $texte
     * @param string $classColor
     * @return string
     */
    private function aff(int $mode, string $texte, string $classColor = 'primary')
    {
        $classSup = " label-$classColor";
        switch ($mode) {
            case self::TITR:
                $p = '<span class="titreasync">' . $texte . '</span>';
                break;
            case self::ITEM:
                $p = '<span class="itemasync">' . $texte . '</span>';
                break;
            case self::TEXT:
                $p = '<span class="texteasync">' . $texte . '</span>';
                break;
            case self::BADG:
                $p = "<span class=\"widFix label$classSup\">" . $texte . "</span>";
                break;
            case self::BADGV:
                $p = "<span class=\"label$classSup\">" . $texte . "</span>";
                break;
        }
        return $p;
    }

    /**
     * @Route("/ajax/calculate/{licMode}", name="ajax_calculate")
     * @return Response
     */
    public function indexAjaxCalculate()
    {
        // Avant de calculer la cotisation, on regarde si il y a a traiter une réduction famille
        // Réduction famille

        /** @var Adherent $user */
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $form = $_POST['inscription'];
        $inscrType = $form['InscrType'];

        $calc = new Calculate();

        $reducFam   = $form['ReducFam'];
        $reducFamId = $user->getReducFamilleID();

        if ($reducFam != '') {

            $res = $calc->calcReducFam($reducFam, $reducFamId, $em);

            $return_val['code'] = $res['fErr'];

            switch ($res['fErr']) {

                case Calculate::ID_VIDE:
                    $return_val['famille'] = '';
                    $return_val['msgFamille'] = '';
                    break;

                case Calculate::OK:
                    ob_start();
                    $this->ligne($this->aff(self::TITR, 'Réduction famille'));
                    $this->ligne(
                        $this->aff(self::BADGV, $res['msg'], 'success') .
                        $this->aff(self::TEXT, "est identifié comme premier membre de la famille pour la réduction famille")
                    );
                    $return_val['famille'] = $reducFam;
                    $return_val['msgFamille'] = ob_get_clean();
                    break;

                case Calculate::DEJA_UTILISE:
                    ob_start();
                    $this->ligne($this->aff(self::TITR, 'Réduction famille'));
                    $this->ligne(
                        $this->aff(self::TEXT, "Désolé mais l'adhérent associé à cet identifiant bénéficie " .
                            "déjà d'une réduction famille et ne peut de ce fait être utilisé")
                    );
                    $return_val['famille'] = '';
                    $return_val['msgFamille'] = ob_get_clean();
                    break;

                case Calculate::ADH_INCONNU:
                    ob_start();
                    $this->ligne($this->aff(self::TITR, 'Réduction famille'));
                    $this->ligne(
                        $this->aff(self::TEXT, "Désolé mais ") .
                        $this->aff(self::BADGV, "$reducFam", 'danger') .
                        $this->aff(self::TEXT, "n'est pas associé à un adhérent inscrit ou en cours d'inscription")
                    );
                    $return_val['famille'] = '';
                    $return_val['msgFamille'] = ob_get_clean();
                    break;

                case Calculate::ID_ERROR:
                    ob_start();
                    $this->ligne($this->aff(self::TITR, 'Réduction famille'));
                    $this->ligne(
                        $this->aff(self::TEXT, "Désolé mais ") .
                        $this->aff(self::BADGV, "$reducFam", 'danger') .
                        $this->aff(self::TEXT, "n'est pas un identifiant de réduction famille valide")
                    );
                    $return_val['famille'] = '';
                    $return_val['msgFamille'] = ob_get_clean();
                    break;

                case Calculate::ID_PERSONEL:
                    ob_start();
                    $this->ligne($this->aff(self::TITR, 'Réduction famille'));
                    $this->ligne(
                        $this->aff(self::TEXT, "Désolé mais") .
                        $this->aff(self::BADGV, "$reducFam", 'danger') .
                        $this->aff(self::TEXT, "est votre identifiant personnel et ne peut être utilisé pour votre inscription")
                    );
                    $return_val['famille'] = '';
                    $return_val['msgFamille'] = ob_get_clean();
                    break;
            }
        } else {
            $return_val['code'] = Calculate::ID_VIDE;
            $return_val['msgFamille'] = '';
        }

        ob_start(); ?>
        <style>
            .texteasync {
                font-size: medium;
                padding-left: 5px;
            }

            .ligneasync {
                display: block;
            }

            .widFix {
                display: inline-block;
                width: 4em;
            }

            .titreasync {
                display: block;
                font-size: large;
                font-style: italic;
                color: #234567;
                margin-top: 10px;
            }

            .itemasync {
                font-size: medium;
                padding-left: 20px;
            }
        </style>
        <?php

        $return_val['css'] = ob_get_clean();

        $tt = json_decode(json_encode($calc->calcCotis($form)), true);

        if (!$tt['fErr']) {
            ob_start();

            if ($inscrType == FormConst::INSCR_NORMAL) {
                $this->ligne(
                    $this->aff(self::TITR, "Montant calculé de votre cotisation selon les informations fournies :")
                );

                $total = $tt['prixCotis'] + $tt['prixLicence'] - $tt['prixRemb'] - $tt['prixReduc'];

                $this->ligne(
                    $this->aff(self::ITEM, '') .
                    $this->aff(self::BADG, $tt['prixCotis'] . "€") .
                    $this->aff(self::TEXT, "pour la cotisation club : (" . $tt['typeCotis'] . ")")
                );
                $this->ligne(
                    $this->aff(self::ITEM, '') .
                    $this->aff(self::BADG, $tt['prixLicence'] . "€") .
                    $this->aff(self::TEXT, "pour la licence : (" . $tt['typeLicence'] . ")")
                );
                if ($tt['typeReduc'] != 'Aucune' || $tt['typeRemb'] != 'Aucun') {
                    $this->ligne($this->aff(self::TITR, "Auxquelles s'appliquent la/les réduction(s) suivante(s) : "));
                    if ($tt['typeReduc'] != 'Aucune') {
                        $this->ligne(
                            $this->aff(self::ITEM, '') .
                            $this->aff(self::BADG, '-' . $tt['prixReduc'] . "€") .
                            $this->aff(self::TEXT, "de " . $tt['typeReduc'])
                        );
                    }
                    if ($tt['typeRemb'] != 'Aucun') {
                        $this->ligne(
                            $this->aff(self::ITEM, '') .
                            $this->aff(self::BADG, '-' . $tt['prixRemb'] . "€") .
                            $this->aff(self::TEXT, "de " . $tt['typeRemb'])
                        );
                    }
                }
            } else {
                $total = $tt['prixLicence'];

                $this->ligne(
                    $this->aff(self::TITR, "Montant calculé de votre licence Passager selon les informations fournies :")
                );
                $this->ligne(
                    $this->aff(self::ITEM, '') .
                    $this->aff(self::BADG, $tt['prixLicence'] . "€") .
                    $this->aff(self::TEXT, "licence FFESSM : (" . $tt['typeLicence'] . ")")
                );
            }
        } else {
            echo $this->aff(self::TITR, "Calcul de la cotisation et de la licence impossible, Vérifiez votre saisie");
        }

        if (isset($form['Assurance'])) {
            $assurance = $form{'Assurance'};
        } else {
            $assurance = '';
        }
        $axa = json_decode(json_encode($calc->calcAxa($assurance)), true);

        if (!$axa['fErr']) {
            if ($axa['typeAxa'] != FormConst::A_NONE) {
                $this->ligne($this->aff(self::TITR, "Assurance personnelle (Axa) : "));
                $this->ligne(
                    $this->aff(self::ITEM, '') .
                    $this->aff(self::BADG, $axa['prixAxa'] . "€") .
                    $this->aff(self::TEXT, "pour le niveau de garanties choisies : (" . $axa['typeAxa'] . ")")
                );
            }
        } else {
            echo $this->aff(self::TITR, "Calcul de l'assurance impossible, Vérifiez votre saisie");
        }

        $return_val['detail'] = ob_get_clean();

        ob_start();

        if (!$tt['fErr']) {
            $this->ligne($this->aff(self::TITR, "Sommes à régler : "));
            if ($inscrType == FormConst::INSCR_NORMAL) {
                $this->ligne(
                    $this->aff(self::ITEM, "Un cheque de ") .
                    $this->aff(self::BADG, $total . "€", 'success') .
                    $this->aff(self::TEXT, "à l'ordre du GUC Plongée : ")
                );
            } else {
                $this->ligne(
                    $this->aff(self::ITEM, "Un cheque de ") .
                    $this->aff(self::BADG, $total . "€", 'success') .
                    $this->aff(self::TEXT, "à l'ordre du GUC Plongée : ")
                );

            }
        }
        if (!$axa['fErr']) {
            if ($axa['typeAxa'] != FormConst::A_NONE) {
                $this->ligne(
                    $this->aff(self::ITEM, "Un cheque de ") .
                    $this->aff(self::BADG, $axa['prixAxa'] . "€", 'success') .
                    $this->aff(self::TEXT, "à l'ordre de AXA Assurances")
                );
            }
        }

        $return_val['total'] = ob_get_clean();

        $tt = json_encode($return_val);
        $uu = new Response($tt);

        return $uu;
    }
}