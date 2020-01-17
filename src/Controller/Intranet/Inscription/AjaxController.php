<?php

namespace App\Controller\Intranet\Inscription;

use App\Classes\Form\FormConst;
use App\Classes\Inscription\Calculate;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController extends AbstractController
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
     * @Route("/ajax/calculate/{licMode}", options={"expose"=true}, name="ajax_calculate")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function indexAjaxCalculate(EntityManagerInterface $em, Request $request)
    {
        // Avant de calculer la cotisation, on regarde si il y a a traiter une réduction famille
        // Réduction famille

        /** @var User $user */
        $user = $this->getUser();

        $form = $request->get('inscription');

        $inscrType = $form['InscrType'];
        $reducFam  = $form['ReducFam'];

        $calc = new Calculate();

        $reducFamId = $user->getReducFamilleID();

        $rf['famille'] = $reducFam;

        if ($reducFam != '') {

            $res = $calc->calcReducFam($reducFam, $reducFamId, $em);

            $rf['code']    = $res['fErr'];

            switch ($res['fErr']) {
                case Calculate::ID_VIDE:      $rf['type'] = 'vide';         break;
                case Calculate::OK:           $rf['type'] = 'ok';           break;
                case Calculate::DEJA_UTILISE: $rf['type'] = 'deja_utilise'; break;
                case Calculate::ADH_INCONNU:  $rf['type'] = 'inconnu';      break;
                case Calculate::ID_ERROR:     $rf['type'] = 'error';        break;
                case Calculate::ID_PERSONEL:  $rf['type'] = 'perso';        break;
            }
        }

        $res = $this->renderView('inscription/calculate_reducfam.html.twig', [
            'reducFam' => $rf
        ]);

        $tab['msgFamille'] = $res;

        $tt = $calc->calcCotis($form);

        if (isset($form['Assurance'])) {
            $assurance = $form['Assurance'];
        } else {
            $assurance = '';
        }
        $axa = $calc->calcAxa($assurance);

        $detail = $this->renderView('inscription/calculate_detail.html.twig', [
            'inscrType' => $inscrType,
            'cotis' => $tt,
            'assur' => $axa

        ]);

        $tab['detail'] = $detail;

        $total = $this->renderView('inscription/calculate_total.html.twig', [
            'inscrType' => $inscrType,
            'cotis' => $tt,
            'assur' => $axa

        ]);

        $tab['total'] = $total;

        return new JsonResponse(json_encode($tab));
    }
}
