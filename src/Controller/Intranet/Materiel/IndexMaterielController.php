<?php

namespace App\Controller\Intranet\Materiel;

use App\Classes\Materiel\ListeMateriel;
use App\Classes\Materiel\Resa;
use App\Classes\Resa\Element;
use App\Classes\Resa\Reservation;
use App\Entity\Adherent;
use App\Entity\Calendrier;
use App\Entity\LocRefs;
use App\Entity\MatCal;
use App\Entity\MatCarac;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class IndexMaterielController extends AbstractController
{

    /**
     * @Route("/intranet/materiel/demande", name="index_demande_emprunt")
     * @param EntityManagerInterface $em
     * @param SessionInterface $session
     * @param LoggerInterface $gucLogger
     * @return Response
     * @throws Exception
     */
    public function indexDemandeEmprunt(EntityManagerInterface $em, SessionInterface $session, LoggerInterface $gucLogger)
    {
        $gucLogger->info('log1');

        $resa = new Resa($em);

        if (isset($_GET['action']) && $_GET['action'] == 'delete') {
            // Suppression d'un item

            $item = $_GET['item'];
            $resa->libereResa($item);
        }

        if (isset($_POST['checkdata'])) {
            // Traitement de la demande de reservation

            // Prise en compte de la demande de réservation

            /** @var Reservation $reservation */
            $reservation = $session->get('reservation');

            if ($reservation != null) {
                // Check et Changement du status de preReserve vers reserve

                if ($reservation->dateRetour != null && $reservation->dateSortie != null &&
                    $reservation->typeSortie != '-' && count($reservation->items) > 0) {
                    // Demande valide

                    // Création d'une ref de résa

                    foreach ($reservation->items as $k => $item) {
                        // /** @var Element $item
                        $resa->confirmerRef($item->numResa);
                    }
                    $reservation->items = [];
                    $lrr = $em->getRepository(LocRefs::class);
                    $reservation->refResa = $lrr->getRefResa();
                    $session->set('reservation', null);
                    $msgerr = "Votre demande de matériel est enregistrée";
                } else {
                    $msgerr = 'Veuillez compléter la demande avant de la soumettre';
                }
            }
        }


// Construction de la liste des réservations en cours pour l'utilisateur (ayant le status reserve ou encours)

        /** @var Adherent $User */
        $User = $this->getUser()->getId();
        /** @var MatCal[] $encours */
        $encours = $em->createQueryBuilder()
            ->select(['m','mc'])
            ->from(MatCal::class, 'm')
            ->leftJoin('m.MatCarac','mc')
            ->where("m.RefUser = $User")
            ->andWhere("m.status = 'reserve'")
            ->orWhere("m.status = 'encours'")
            ->orderBy("m.RefResa", "ASC")
            ->getQuery()
            ->getResult();

        /**
         * @var  MatCal $r
         */
        $refResa = 0;
        $tabEmprunts = [];
        $rex = 0;

        foreach ($encours as $r) {
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
                $rex['assets']          = [];
            }
            $x = $r->getMatCarac();
            $Detail = [];
            $Detail['Ref']     = $r->getId();
            $Detail['Num']     = $x->getAssetNum();
            $Detail['Type']    = $x->getAssetType();
            $Detail['Count']   = $x->getUsageCount();
            $Detail['Status']  = $r->getStatus();
            $Detail['Carac']   = $x->getCaracteristique();

            $rex['assets'][] = $Detail;
        }
        if ($rex != 0) {
            $tabEmprunts[] = $rex;
        }

// Rendering de la page

        $msgerr = '';
        return $this->render('intranet/materiel/mat_index_demande_emprunt.html.twig', [
            'listeSorties' => ListeMateriel::SELSORTIES,
            'tabEmprunts' => $tabEmprunts,
            'msgErr' => $msgerr
        ]);
    }

    /**
     * @Route("/intranet/materiel/ajax/prereservation", name="ajax_pre_reservation")
     * @param EntityManagerInterface $em
     * @return Response
     * @throws Exception
     */
    public function ajaxDemandeMat(EntityManagerInterface $em, SessionInterface $session)
    {
        $reservation = $session->get('reservation',null);

        $resa = new Resa($em);
        if ($reservation == null) {
            $reservation = new Reservation();
            $reservation->refResa = $em->getRepository(LocRefs::class)->getRefResa();
        }

        $session->set('reservation',$reservation);

        $matCarac = $em->getRepository(MatCarac::class);
        $listeMat = $matCarac->getDistinctTypes();

        $commande = $_POST['commande'];

        // Vérif que les pré-résa sont toujours valides
        $resTarget = [];
        $resa->libereExpiredPreResa();
        foreach ($reservation->items as $v) {
            if ($resa->verifierRef($v->numResa) != false) {
                $resa->resetExpiredPreResa($v->numResa);
                $resTarget[] = $v;
            }
        }
        $reservation->items = $resTarget;

        if (isset($_POST['typeMat']) && $_POST['typeMat'] != '') {
            $typeMat = $_POST['typeMat'];
        }
        if (isset($_POST['dateSortie']) && $_POST['dateSortie'] != '') {
            $reservation->dateSortie = $_POST['dateSortie'];
        }
        if (isset($_POST['dateRetour']) && $_POST['dateRetour'] != '') {
            $reservation->dateRetour = $_POST['dateRetour'];
        }
        if (isset($_POST['typeSortie']) && $_POST['typeSortie'] != '') {
            $reservation->typeSortie = $_POST['typeSortie'];
        }

        $user = $this->getUser();
        /** @var Adherent $user */
        $userId = $user->getId();
        switch ($commande) {
            case 'addMat':
                $matCar = $_POST['caracMat'];
                $numResa = $resa->reserveResa(
                    $reservation->dateSortie,
                    $reservation->dateRetour,
                    $userId,
                    $typeMat,
                    $reservation->typeSortie,
                    $reservation->refResa,
                    $matCar,
                    "",
                    "preReserve"
                );
                if ($numResa != false) {
                    $mat = new Element();
                    $mat->type = $typeMat;
                    $mat->caract = $matCar;
                    $tab = $resa->rechercheDetailsResa($numResa);
                    $mat->numResa = $numResa->getId();
                    $mat->itemText = $tab->getMatCarac()->getAssetNum();
                    $reservation->items[] = $mat;
                }
                break;

            case 'supMat':
                $row = $_POST['row'];
                /** @var Element $element */
                if (isset($reservation->items[$row])) {
                    $element = $reservation->items[$row];
                    $resa->libereResa($element->numResa);
                    array_splice($reservation->items, $row, 1);
                }
                break;

            case 'dateChange':
                $ds = new DateTime($reservation->dateSortie);
                $dr = new DateTime($reservation->dateRetour);
                if ($dr <= $ds) {
                    $dr = clone $ds;
                    $dr->add(new \DateInterval('P7D'));
                }
                $reservation->dateSortie = $ds->format('Y-m-d');
                $reservation->dateRetour = $dr->format('Y-m-d');
                // Tout libérer
                $items = $reservation->items;
                foreach ($items as $item) {
                    /** @var Element $item */
                    $resa->libereResa($item->numResa);
                }
                $cible = [];
                foreach ($items as $item) {
                    /** @var Element $item */
                    $res = $resa->reserveResa(
                        $reservation->dateSortie,
                        $reservation->dateRetour,
                        $userId,
                        $reservation->numResa,
                        $item->type,
                        $reservation->refResa,
                        $item->caract,
                        "",
                        "preReserve"
                    );
                    if ($res != false) {
                        $tab = $resa->rechercheDetailsResa($res);
                        $item->numResa = $res;
                        $item->itemText = $tab['Num'];
                        $cible[] = $item;
                    }
                }
                $reservation->items = $cible;

                // Essayer de renouveler aux nouvelles dates
                break;
            case 'init':
                break;
            default:
                return new Response('<h3>Error</h3>');
        }

        /**
         * Recherche des matériels de ce type disponibles aux dates demandées
         * Et affichage des caratctéristiques
         */
        if ($reservation->dateSortie != null && $reservation->dateRetour != null) {
            /**
             * Recherche dans la base
             */
            $tabCaract = $resa->listeAvailableCaract(
                $reservation->dateSortie,
                $reservation->dateRetour,
                $_POST['typeMat']
            );
            if ($tabCaract == false) {
                $tabCaract = ["" => 0];
            }
        } else {
            $tabCaract[] = "Renseignez les dates de sortie et de retour";
        }

        // Recherche des dates valides

        $crep = $em->getRepository(Calendrier::class);
        $datesSortie = $crep->findDatesAfter(new DateTime('now', new DateTimeZone('Europe/Paris')),['seanceBassin' => 'O']);
        $datesRetour = $crep->findDatesAfter(new DateTime($reservation->dateSortie, new DateTimeZone('Europe/Paris')),['seanceBassin' => 'O']);

        // Formulaire mini

        $session->set('reservation', $reservation);

        return $this->render('intranet/materiel/ajax_demande_mat.html.twig', [
            'post' => $_POST,
            'typeMat' => $typeMat,
            'typSortie' => ListeMateriel::SELSORTIES,
            'resa' => $reservation,
            'tabRes' => $listeMat,
            'tabCaract' => $tabCaract,
            'datesSortie' => $datesSortie,
            'datesRetour' => $datesRetour
        ]);
    }
}
