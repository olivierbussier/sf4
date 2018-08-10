<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexGalerieController extends Controller
{
    /**
     * @Route("/index_galerie", name="index_galerie")
     */
    public function index()
    {
        return $this->render('pages/index_galerie.html.twig');
    }
}
