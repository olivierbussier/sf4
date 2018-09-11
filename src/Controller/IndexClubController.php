<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexClubController extends Controller
{
    /**
     * @Route("/index_presentation", name="index_presentation")
     */
    public function presentation()
    {
        return $this->render('pages/index_presentation.html.twig');
    }

    /**
     * @Route("/index_tarifs", name="index_tarifs")
     */
    public function tarifs()
    {
        return $this->render('pages/index_tarifs.html.twig');
    }

    /**
     * @Route("/index_whoswho", name="index_whoswho")
     */
    public function index()
    {
        return $this->render('pages/index_whoswho.html.twig');
    }

    /**
     * @Route("/index_exploration", name="index_exploration")
     */
    public function exploration()
    {
        return $this->render('pages/index_exploration.html.twig');
    }

    /**
     * @Route("/index_materiel", name="index_materiel")
     */
    public function materiel()
    {
        return $this->render('pages/index_materiel.html.twig');
    }

    /**
     * @Route("/index_gonflage", name="index_gonflage")
     */
    public function compresseurGonglage()
    {
        return $this->render('pages/index_gonflage.html.twig');
    }

    /**
     * @Route("/index_coordonnees", name="index_coordonnees")
     */
    public function coordonnees()
    {
        return $this->render('pages/index_coordonnees.html.twig');
    }
}
