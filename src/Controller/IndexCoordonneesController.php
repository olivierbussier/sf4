<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexCoordonneesController extends Controller
{
    /**
     * @Route("/index_coordonnees", name="index_coordonnees")
     */
    public function index()
    {
        return $this->render('pages/index_coordonnees.html.twig');
    }
}
