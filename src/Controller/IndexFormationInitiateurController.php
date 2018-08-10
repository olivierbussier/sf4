<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexFormationInitiateurController extends Controller
{
    /**
     * @Route("/index_formation_initiateur", name="index_formation_initiateur")
     */
    public function index()
    {
        return $this->render('pages/index_formation_initiateur.html.twig');
    }
}
