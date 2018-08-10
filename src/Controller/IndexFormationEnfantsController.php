<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexFormationEnfantsController extends Controller
{
    /**
     * @Route("/index_formation_enfants", name="index_formation_enfants")
     */
    public function index()
    {
        return $this->render('pages/index_formation_enfants.html.twig');
    }
}
