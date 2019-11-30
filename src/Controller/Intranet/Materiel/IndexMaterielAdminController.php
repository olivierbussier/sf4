<?php

namespace App\Controller\Intranet\Materiel;

use App\Classes\Helpers\DateHelper;use App\Classes\Materiel\Resa;
use App\Entity\Adherent;use App\Entity\MatCal;
use App\Entity\MatCarac;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexMaterielAdminController extends AbstractController
{

    /**
     * @Route("/intranet/materiel/admin_demandes", name="admin_demandes")
     */
    public function adminDemandes()
    {
        /*
         * Administration des demandes d'emprunt
         *
         * Chaque modification de la base est tracée (materiel.log)
         *  - nom de l'auteur de la modif
         *  - date et heure de la modif
         *  - nature de ma modif
         *  - matériels concernés
         *
         * Différents cas possibles :
         *  Pour les sorties :
         *  - La personne retire le matériel qu'elle à réservé (cas nominal)
         *  - La personne retire le matériel réservé par un autre
         *  - La personne s'est trompé dans sa résa (mauvaise taille, bloc en trop, oubli de matériel, date, ...)
         *  - La personne n'a pas réservé
         *  - La personne a réservé pour un groupe
         *
         * Pour les restitutions :
         *  - La personne rend le matériel qu'elle à réservé (cas nominal)
         *  - La personne rend du matériel pour plusieurs personnes
         *  - La personne ne vient pas rendre le matériel
         *  - La personne rend du matériel réservé par un autre
         *  - La personne rend du matériel non réservé ?
         *  - La personne signale une anomalie sur un ou plusieurs matériels
         */
/*
        if (!Session::checkDroits(Session::MAT_MGR)) {
            include __DIR__ . "/index_intranet.php";
            exit;
        }
*/
        if (isset($_POST['search'])) {
            $search = $_POST['search'];
        } else {
            $search = '';
        }

        return $this->render('intranet/materiel/mat_index_admin_demandes.html.twig', [
            'startPage' => 0,
            'search' => $search
        ]);
    }

    /**
     * @Route("/intranet/materiel/ajax_admin_demandes/{page}", name="ajax_admin_demandes")
     * @param $page
     * @return Response
     * @throws \Exception
     */
    public function ajaxAdminDemandes(EntityManagerInterface $emr, $page=1)
    {
        $nbArticlesParPage = 10;

        $em = $this->getDoctrine()->getManager();

        $search = isset($_GET['search']) ? $_GET['search']:'';

        $reservations = $em->getRepository(MatCal::class)
            ->findAllPagineEtTrie($page, $nbArticlesParPage, $search);

        $pagination = array(
            'page' => $page,
            'nbPages' => ceil(count($reservations) / $nbArticlesParPage),
            'nomRoute' => 'ajax_admin_demandes',
            'paramsRoute' => []
        );

        $refResa = 0;
        $tabEmprunts = [];
        $rex = 0;
        $resa = new Resa($emr);

        /** @var MatCal $r */
        foreach ($reservations as $r) {
            if ($refResa != $r->getRefResa()) {
                if ($rex != 0) {
                    $tabEmprunts[] = $rex;
                }
                $rex = [];
                $refResa =$r->getRefResa();
                $rex['RefResa']         = $r->getRefResa();
                $rex['dateSortie']      = $r->getDateDebut()->format('d/m/Y');
                $rex['dateRetour']      = $r->getDateFin()->format('d/m/Y');
                $rex['typeSortie']      = $r->getTypeSortie();
                $rex['commentaire']     = $r->getTypeSortie();
                $rex['status']          = $r->getStatus();
                $rex['user']            = $r->getRefUser()->getUsername();
                $rex['userid']          = $r->getRefUser()->getId();
                $rex['assets']          = [];
            }
            /** @var MatCarac $x */
            $x = $r->getMatCarac();
            $Detail = [];
            $Detail['Ref']     = $r->getId();
            $Detail['Num']     = $x->getAssetNum();
            $Detail['Type']    = $x->getAssetType();
            $Detail['Count']   = $x->getUsageCount();
            $Detail['Status']  = $r->getStatus();
            $Detail['Carac']   = $x->getCaracteristique();
            $Detail['otherItems']   = $resa->getConflit(
                $r->getDateDebut()->format('Y-m-d'),
                $r->getDateFin()->format('Y-m-d'),
                $x->getAssetType(),
                $x->getAssetNum()
            );

            $rex['assets'][] = $Detail;
        }
        if ($rex != 0) {
            $tabEmprunts[] = $rex;
        }

        return $this->render('intranet/materiel/ajax_admin_demandes.html.twig',[
            'reservations' => $tabEmprunts,
            'page' => $page,
            'nbPages' => ceil(count($reservations) / $nbArticlesParPage),
            'pagination' => $pagination,
            'search' => $search
        ]);

        if (isset($_GET['search'])) {
            $search = $db->escape($_GET['search']);
            $qsearch = " where typeSortie like '%$search%' or " .
                "AssetType like '%$search%' or " .
                "AssetNum like '%$search%' or " .
                "nom like '%$search%' or " .
                "prenom like '%$search%' or " .
                "caracteristique like '%$search%' or " .
                "@#@loc_matcal.status like '%$search%'";
        } else {
            $search = '';
            $qsearch = '';
        }

        if (isset($_GET['startPage'])) {
            $startPage = $_GET['startPage'];
        } else {
            $startPage = 0;
        }

        $nbItemsParPage = 2000;

        $baseSql = "from @#@loc_matcal " .
            "join @#@loc_matcarac on @#@loc_matcarac.Ref = @#@loc_matcal.AssetRef " .
            "join @#@liste on @#@liste.Ref = @#@loc_matcal.RefUser" . $qsearch;

        $res = $db->query("select count(*) " . $baseSql . " group by @#@loc_matcal.RefResa");
        $nbItems = $db->nextrow($res)['count(*)'];


        $nbPages = ((int)($nbItems / $nbItemsParPage)) + (($nbItems % $nbItemsParPage) != 0 ? 1 : 0);

        if ($startPage > $nbPages) {
            $startPage = $nbPages - 1;
        }

        $finalQuery = "select @#@loc_matcal.Ref as locref, " .
            "@#@loc_matcal.RefResa as refresa, " .
            "@#@loc_matcal.typeSortie as loctyp, " .
            "@#@loc_matcal.ddeb as caldeb, " .
            "@#@loc_matcal.dfin as calfin, " .
            "@#@loc_matcal.status as calsta, " .
            "@#@loc_matcarac.AssetNum as carnum, " .
            "@#@loc_matcarac.AssetType as cartyp, " .
            "@#@loc_matcarac.Caracteristique as carcar, " .
            "@#@loc_matcarac.Status as carsta, " .
            "@#@liste.nom as nom," .
            "@#@liste.prenom as prenom " .
            "$baseSql order by nom, prenom, @#@loc_matcal.RefResa, caldeb " .
            "limit " . ($nbItemsParPage * $startPage) . "," . "$nbItemsParPage";

        $res = $db->query($finalQuery);
        $tabAsset = [];

        $tabEmprunts = [];
        $refResa = 0;
        $rex = 0;


        while (($d = $db->nextrow($res)) != false) {
            if ($refResa != $d['refresa']) {
                if ($rex != null) {
                    $tabEmprunts[] = $rex;
                }

                $refResa = $d['refresa'];
                $rex = new Reservation();
                $rex->ref = $d['locref'];
                $rex->refResa = $d['refresa'];
                $rex->typeSortie = $d['loctyp'];
                $rex->nom = $d['nom'];
                $rex->prenom = $d['prenom'];
                $rex->dateSortie = $d['caldeb'];
                $rex->dateRetour = $d['calfin'];
            }

            $item = new Element();

            $item->type = $d['cartyp'];
            $item->caract = $d['carcar'];
            $item->numResa = $d['locref'];
            $item->itemText = $d['carnum'];
            $item->commentaire = '';

            // Recherche des autres assets de ce groupe avec leur infos de dispo

            $r2 = Resa::getConflit(
                $d['caldeb'],
                $d['calfin'],
                $d['cartyp'],
                $d['carnum']
            );

            $rex->items[] = [
                'item' => $item,
                'otherItems' => $r2
            ];
            $tabAsset[] = $rex;
        }

        $tabEmprunts[] = $rex;


// Formulaire mini

        $ret = $twig->render('materiel/ajax_admin_demandes.html.twig', [
            'startPage' => $startPage,
            'nbPages' => $nbPages,
            'reservations' => $tabEmprunts,
            'search' => $search,
            'q' => $finalQuery
        ]);

        echo $ret;

        }

    /**
     * @Route("/intranet/materiel/admin_demandes_excel", name="admin_demandes_excel")
     */
    public function adminDemandesExcel()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/materiel/admin_calendrier_materiel", name="admin_calendrier_materiel")
     * @param EntityManagerInterface $em
     * @return Response
     * @throws \Exception
     */
    public function adminCalendrierMateriel(EntityManagerInterface $em)
    {
        /*
        <style>
            td.reserve     { background-color: rgba(255, 197,   0, 0.34);}
            td.encours     { background-color: rgba(255,   0,   0, 0.34);}
            td.restitue    { background-color: rgba( 12, 155,  15, 0.34);}
            td.maintenance { background-color: rgba(170, 170, 170, 0.34);}
            td.wlegend     { width:200px; }
        </style>
        */


        /* Affichage :
        +-----------------------------+-----------------------------------------------------------------------------------------------------------------------+
        |           Décembre 2016     |                                Janvier 2017                                                                           |
        +----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+
        |         |  L |  M |  M |  J |  V |  S |  D |  L |  M |  M |  J |  V |  S |  D |  L |  M |  M |  J |  V |  S |  D |  L |  M |  M |  J |  V |  S |  D |
        |  G U C  +----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+
        |         | 28 | 29 | 30 | 31 |  1 |  2 |  3 |  4 |  5 |  6 |  7 |  8 |  9 | 10 | 11 | 12 | 13 | 14 | 15 | 16 | 17 | 18 | 19 | 20 | 21 | 22 | 23 | 24 |
        +---------+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+
        | DET G79 | XXXXXXXXXXXXXXXXXXXXXX |                                  |                                  |                             |              |
        +---------+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+
        | DET G80 |                        | XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX |                                  |                             |              |
        +---------+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+----+

        Le 1er jour affiché est le Lundi précédent (si on est Lundi alors le 1er jour affiché est le Lundi précédent)
        */

        // Appuis <précédent> ou <suivant>

        if (isset($_POST['calprec'])) {
            $cal_startdate = new DateHelper($_POST['caldeb']);
            $cal_startdate->setTime(0, 0, 0);
            $cal_startdate = $cal_startdate->sub(new DateInterval('P21D'));
        }

        if (isset($_POST['calsuiv'])) {
            $cal_startdate = new DateHelper($_POST['caldeb']);
            $cal_startdate->setTime(0, 0, 0);
            $cal_startdate = $cal_startdate->add(new DateInterval('P21D'));
        }

        // Gestion de la date de debut du calendrier
        // -------------------------------------------------

        if (isset($_POST['setdate'])) {
            if ($_POST['ddeb'] != '') {
                $cal_startdate = new DateHelper(DateHelper::dgm($_POST['ddeb']));
            } else {
                $cal_startdate = new DateHelper();
                $cal_startdate->setTime(0, 0, 0);
            }
        }

        // Init par défaut de la date de démarrage du calendrier

        if (!isset($cal_startdate)) {
            if (!isset($_POST['caldeb'])) {
                $cal_startdate = new DateHelper();
                $cal_startdate->setTime(0, 0, 0);
            } else {
                $cal_startdate = new DateHelper($_POST['caldeb']);
            }
        }

        // Gestion des boutons présents sur une réservation
        // -------------------------------------------------

        $resa = new Resa($em);

        if (isset($_POST['Liberer'])) {
            $ref  = $_POST['RefResa'];
            if ($resa->libereResa($ref) == false) {
                echo "<br>Erreur sur la libération de matériel<br>\n";
            }
        }

        if (isset($_POST['Sortir'])) {
            if (isset($_POST['assetres'])) {
                $assetnum = $_POST['assetres'];
            } else {
                $assetnum = '';
            }
            $user     = $_POST['user'];
            $ddeb     = $_POST['ddeb'];
            $dfin     = $_POST['dfin'];
            $asset    = $_POST['asset'];
            if ($resa->sortirAsset($ddeb, $dfin, $user, $asset, $assetnum) == false) {
                echo "<br>Erreur sur la libération de matériel<br>\n";
            }

            // Correction de la date de début du calendrier pour éviter
            // Le recul d'une semaine a chaque click

            $cal_startdate->add(new DateInterval('P1D'));
        }

        if (isset($_POST['Restit'])) {
            $user  = $_POST['user'];
            $ddeb  = $_POST['ddeb'];
            $dfin  = $_POST['dfin'];
            $asset = $_POST['asset'];
            if ($resa->restituerAsset($ddeb, $dfin, $user, $asset) == false) {
                echo "<br>Erreur sur la libération de matériel<br>\n";
            }
        }

        // Gestion du formulaire de réservation
        // ----------------------------------------
        if (isset($_POST['Submit'])) {
            // Résa a faire
            $Nom   = $_POST['nom'];
            $ddeb  = $_POST['ddeb'];
            $dfin  = $_POST['dfin'];
            $stat  = $_POST['status'];
            $mat   = $_POST['materiel'];
            $asset = $_POST['asset'];
            if ($ddeb == '' || $dfin == '') {
                echo "<p>Erreur dans les dates</p>";
            } else {
                if ($asset == 'Auto') {
                    if ($resa->reserveResa($ddeb, $dfin, $Nom, $mat, '', '', $stat)== false) {
                        echo "Erreur réservation";
                    }
                } else {
                    if ($resa->reserveResa($ddeb, $dfin, $Nom, $mat, '', $asset, $stat) == false) {
                        echo "Erreur réservation";
                    }
                }
            }
        }

        $dow = $cal_startdate->format('N');

        // nb de jours pour aller au Lundi d'avant
        if ($dow == 1) {
            $cal_startdate->sub(new DateInterval('P7D'));
        } else {
            $cal_startdate->sub(new DateInterval('P'.($dow-1).'D'));
        }

        $nbsemaines = 4;

        $cal_enddate = clone $cal_startdate;
        $cal_enddate->add(new DateInterval('P'.($nbsemaines).'W'));

        // Le tableau qui suit est divisé en colonnes de 1j
        $nbcols = $nbsemaines*7;

        // Affichage des réservations effectives
        // Récuperation du calendrier objets

        $startd      = $cal_startdate->format('Y-m-d');
        $endd        = $cal_enddate->format('Y-m-d');

        // Liste des réservations entre ddeb et dfin

        // On va chercher les assets réservées pour ce User
        // -> Toutes les lignes de matcal avec un status non libre, et une période en recouvrement avec
        //    le calendrier affiché.
        // -> On trie les assets par refResa afin de pouvoir les regrouper

        $mat = $em->createQueryBuilder()
            ->select('ml, ad')
            ->from (MatCal::class,'ml')
            ->join('ml.MatCarac', 'mc')
            ->join('ml.RefUser', 'ad')
            ->where("ml.status <> 'libre'")
            ->andWhere("(((ml.dateDebut >= '$startd') and (ml.dateDebut < '$endd')) or ".
                        "((ml.dateFin >= '$startd') and (ml.dateFin < '$endd'))) or " .
                        "((ml.dateDebut <= '$startd') and (ml.dateFin >= '$endd'))")
            ->orderBy('ml.RefResa, mc.AssetType', 'asc')
            ->getQuery()
            ->execute();

        // Premiere boucle sur les réservations
        // On les regroupe par numéro de réservation

        $prevResa = 0;
        $tabResa = [];
        $curResa = [];
        $lineAsset = [];
        /** @var MatCal $m */
        foreach ($mat as $m) {
            if ($prevResa != $m->getRefResa()) {
                $adh = $m->getRefUser();

                if ($prevResa != 0) {
                    $tabResa[] = $curResa;
                }
                $curResa = [];
                $curResa['assets']  = $lineAsset;
                $curResa['userId'] = $adh->getId();
                $curResa['nom']  = $adh->getNom();
                $curResa['prenom']  = $adh->getPrenom();
                $curResa['dateDebut'] = $m->getDateDebut();
                $curResa['dateFin'] = $m->getDateFin();
                $curResa['typeSortie'] = $m->getTypeSortie();
                $curResa['colsDeb'] = $cal_startdate->diff($m->getDateDebut())->d;

                if ($m->getDateFin() <= $cal_enddate) {
                    // La res finit avant la fin de l'affichage du calendrier
                    // Calcul du nombre de jours a afficher pour cette réservation
                    // Date de fin - cal_startdate

                    $curResa['colsRes'] = $m->getDateFin()->diff($m->getDateDebut())->d;
                    $curResa['colsFin'] = $cal_enddate->diff($m->getDateFin())->days;
                } else {
                    // La res finit après la fin de l'affichage du calendrier
                    // Calcul du nombre de jours a afficher pour cette réservation
                    // date de fin calendrier - date courante

                    $curResa['colsRes'] = $nbcols - $curResa['colsDeb'];
                    $curResa['colsFin'] = 0;
                }

                $curResa['assets'] = [];
                $lineAsset         = [];
                $prevResa          = $m->getRefResa();
            }

            $lineAsset['status'] = $m->getStatus();
            $lineAsset['assetText']  = $m->getAssetText();

            // Recherche dans matcarac des caractéristiques du matériel
            // a afficher

            $matCarac = $m->getMatCarac();
            $lineAsset['AssetNum']  = $matCarac->getAssetNum();
            $lineAsset['AssetType'] = $matCarac->getAssetType();
            $lineAsset['AssetCarac']= $matCarac->getCaracteristique();

            //$Compat    = $matCarac->get['Compatibilite'];

            // Recherche des autres matériels du même type dispo à ces dates

            $debutResa = $m->getDateDebut()->format('Y-m-d');
            $finResa   = $m->getDateFin()->format('Y-m-d');
            $type      = $matCarac->getAssetType();

            $others = $em->createQueryBuilder()
                ->select('ml, mc')
                ->from (MatCal::class,'ml')
                ->join('ml.MatCarac', 'mc')
                ->where("(ml.status = 'libre' or ml.status = 'reserve' or ml.status = 'preReserve' or ml.status = 'encours')")
                ->andWhere("mc.AssetType = '$type'")
                ->andWhere("((ml.dateDebut <= '$debutResa') and (ml.dateFin >= '$finResa'))")
                ->orderBy('mc.Caracteristique, mc.AssetNum', 'asc')
                ->getQuery()
                ->execute();

            $lineAsset['libres'] = $others;
            $curResa['assets'][] = $lineAsset;

        }
        $tabResa[] = $curResa;

        // Calcul du header

        $calHeader['startDate']      = $cal_startdate;
        $calHeader['nbJours'] = $nbcols;
        $calHeader['nbSemaines'] = $nbsemaines;
        $calHeader['lines'] = [];

        $cal_curdate = clone($cal_startdate);
        $totalDays = 0;
        while ($totalDays < $nbcols) {
            $line['curMonth']       = $cal_curdate->format('n') - 1;
            if ($totalDays + $cal_curdate->daysForNextMonth() <= $nbcols) {
                $line['nbDayInMonth'] = $cal_curdate->daysForNextMonth();
            } else {
                $line['nbDayInMonth'] = $nbcols - $totalDays;
            }
            $totalDays += $cal_curdate->daysForNextMonth();
            $line['startDayOfWeek'] = $cal_curdate->format('N') - 1;
            $line['startDay']       = $cal_curdate->format('j');
            $calHeader['lines'][] = $line;
            $cal_curdate->add(new DateInterval("P" . $line['nbDayInMonth'] ."D"));
        }

        return $this->render(
            'intranet/materiel/mat_index_calendrier_adh.html.twig', [
            'calHeader' => $calHeader,
            'tabResa'   => $tabResa
        ]);
    }

    /**
     * @Route("/intranet/materiel/admin_calendrier_adherent", name="admin_calendrier_adherent")
     */
    public function adminCalendrierAdherent()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/materiel/index_admin_genmat", name="index_admin_genmat")
     */
    public function indexAdminGenMat()
    {
        return $this->render('');
    }

}
