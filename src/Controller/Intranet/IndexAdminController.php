<?php

namespace App\Controller\Intranet;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Adherent;
use Symfony\Bridge\Doctrine\RegistryInterface;


class IndexAdminController extends Controller
{
    /**
     * @Route("/intranet/index_admin_affiche_perso", name="index_admin_affiche_perso")
     */
    public function affiche_perso()
    {
        return $this->render('intranet/index_affiche_perso.html.twig');
    }

    /**
     * @Route("/intranet/index_admin_trombi", name="index_admin_trombi")
     */
    public function trombi(RegistryInterface $doctrine)
    {
        $photos = $doctrine->getRepository(Adherent::class)->getAllPhotos();
        dump($photos);
        return $this->render('intranet/index_trombi.html.twig',[
            'photos' => $photos
        ]);
    }

    /**
     * @Route("/intranet/index_admin_calendrier", name="index_admin_calendrier")
     */
    public function adminCalendrier()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/index_admin_status_inscriptions", name="index_admin_status_inscriptions")
     */
    public function adminStatusInscription()
    {
        return $this->render('');
    }
}
