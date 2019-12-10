<?php

namespace App\Controller\Intranet\Gonflage;

use App\Entity\Adherent;
use App\Entity\Calendrier;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexGonflageController extends AbstractController
{
    /**
     * @Route("/gonflage/modif_eleves", name="index_modif_gonf_eleves")
     * @param EntityManagerInterface $em
     * @return Response
     * @throws \Exception
     */
    public function indexModifGonfEleves(EntityManagerInterface $em)
    {
        $cal = $em->getRepository(Calendrier::class);

        /** @var Adherent $usr */
        $usr = $this->getUser();
        //$user = $usr->getNom() . ' ' . $usr->getPrenom();
        $user = 'CARLU Joffrey';

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
