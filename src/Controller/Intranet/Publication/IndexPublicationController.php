<?php

namespace App\Controller\Intranet\Publication;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexPublicationController extends AbstractController
{
    /**
     * @Route("/intranet/index_admin_calendrier", name="index_admin_calendrier")
     */
    public function adminCalendrier()
    {
        return $this->render('intranet/index_admin_calendrier.html.twig');
    }

    /**
     * @Route("/intranet/index_liste_secouristes", name="index_secouristes")
     */
    public function listeSecouristes()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/index_liste_TIV", name="index_TIV")
     */
    public function listeTIV()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/admin_listes_diffusion", name="admin_listes_diffusion")
     */
    public function adminListesDiffusion()
    {
        return $this->render('');
    }
}
