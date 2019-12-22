<?php

namespace App\Controller\Intranet\Gonflage;

use App\Entity\Adherent;
use App\Entity\Calendrier;
use App\Repository\CalendrierRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexGonflageController extends AbstractController
{
    private function errorResponse(string $error = 'Erreur inconnue')
    {

        return new Response(json_encode([
            'error' => $error
        ]), 400);
    }

    /**
     * @Route("/intranet/ajax_calendrier", name="ajax_calendrier")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function ajaxCalendrier(EntityManagerInterface $em, Request $request) : Response
    {

        $id = $request->get('id');
        $value = $request->get('value');

        $v = explode('-',$id);

        if (count($v) < 3 || $v[0] != 'ck') {
            return $this->errorResponse('');
        }

        $ref = $v[1];
        $aide = $v[2];

        if (!is_numeric($ref)) {
            return $this->errorResponse('');
        }

        if ($aide != 'aide1' && $aide != 'aide2' & $aide != 'aide3') {
            return $this->errorResponse('');
        }


        $cal = $em->getRepository(Calendrier::class);
        /** @var Calendrier $dateCal */
        $dateCal = $cal->find($ref);

        /** @var Adherent $usr */
        $usr = $this->getUser();
        $user = $usr->getNom() . ' ' . $usr->getPrenom();

        if ($value == 'false') {
            if ($aide == 'aide1') {
                $dateCal->setAideGonf1('');
            } elseif ($aide == 'aide2') {
                $dateCal->setAideGonf2('');
            } elseif ($aide == 'aide3') {
                $dateCal->setAideGonf3('');
            }
        } elseif ($value == 'true') {
            if ($aide == 'aide1') {
                if ($dateCal->getAideGonf2() != $user && $dateCal->getAideGonf3() != $user) {
                    $dateCal->setAideGonf1($user);
                } else {
                    return $this->errorResponse("Vous ne pouvez vous inscrire qu'une seule fois par date");
                }
            }
            if ($aide == 'aide2') {
                if ($dateCal->getAideGonf1() != $user && $dateCal->getAideGonf3() != $user) {
                    $dateCal->setAideGonf2($user);
                } else {
                    return $this->errorResponse("Vous ne pouvez vous inscrire qu'une seule fois par date");
                }
            }
            if ($aide == 'aide3') {
                if ($dateCal->getAideGonf1() != $user && $dateCal->getAideGonf2() != $user) {
                    $dateCal->setAideGonf3($user);
                } else {
                    return $this->errorResponse("Vous ne pouvez vous inscrire qu'une seule fois par date");
                }
            }
        }
        $em->persist($dateCal);
        $em->flush();

        /** @var CalendrierRepository $cal */
        $seances = $cal->createQueryBuilder('m')
            ->select('m')
            ->where("m.archive = 'non'")
            ->andWhere("m.aideGonf1 = '$user' or m.aideGonf2 = '$user' or m.aideGonf3 = '$user'")
            ->getQuery()
            ->execute();

        return new Response(json_encode([
            'planning' => $this->renderView("intranet/gonflage/_aff_planning.html.twig", [
                'seancesUser' => $seances,
                'user' => $user
            ]),
            'synthese' => $this->renderView("intranet/gonflage/_aff_synthese.html.twig", [
                'seancesValidees' => 1,
                'ACTIVITE' => $usr->getActivite(),
                'nbSeances' => count($seances),
                'nbValidees' => 1,
                'nbNonvalidees' => 1
            ]),
            'checkBox' => [
                'id'    => $request->get('id'),
                'value' => $request->get('value'),
                'fullName' => $user
            ]
        ]));
    }

    /**
     * @Route("/intranet/modif_eleves", name="index_modif_gonf_eleves")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function indexModifGonfEleves(EntityManagerInterface $em, Request $request)
    {
        $cal = $em->getRepository(Calendrier::class);

        /** @var Adherent $usr */
        $usr = $this->getUser();

        $user = $usr->getNom() . ' ' . $usr->getPrenom();

        /** @var CalendrierRepository $cal */
        $seances = $cal->createQueryBuilder('m')
            ->select('m')
            ->where("m.aideGonf1 = '$user'")
            ->orWhere("m.aideGonf2 = '$user'")
            ->orWhere("m.aideGonf3 = '$user'")
            ->getQuery()
            ->execute();

        $todaydate = (new DateTime())->format("Y-m-d");

        $cals = $cal->createQueryBuilder('m')
            ->select('m')
            ->where("m.archive = 'non'")
            ->andWhere("m.date >= '$todaydate'")
            ->orderBy('m.date')
            ->getQuery()
            ->execute();

        return $this->render('intranet/gonflage/modif_eleve.html.twig', [
            'user' => $user,
            'calendrier' => $cals,
            'seancesUser' => $seances,
            'seancesValidees' => 1,
            /** @var Adherent */
            'ACTIVITE' => $usr->getActivite(),
            'msgErreur' => ''
        ]);
    }

    /**
     * @Route("/gonflage/index_status_gonflage_eleves", name="index_status_gonflage_eleves")
     */
    public function indexStatusGonflageEleves()
    {
        return $this->render('');
    }
}
