<?php

namespace App\Controller\Intranet;

use App\Classes\Sheets\Sheets;
use App\Entity\Adherent;
use App\Repository\AdherentRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IntranetController extends Controller
{
    /**
     * @Route("/intranet/index", name="index_intranet")
     */
    public function index(RegistryInterface $doctrine)
    {
        $sheet = Sheets::getSheetURL();

        $user = $this->getUser();
        $adh = $doctrine->getRepository(Adherent::class)->find($user->getId());
        return $this->render('intranet/index.html.twig', [
            'adh' => $adh,
            'sheetBapteme' => $sheet
        ]);
    }
}
