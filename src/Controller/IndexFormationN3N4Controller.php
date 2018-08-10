<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexFormationN3N4Controller extends Controller
{
    /**
     * @Route("/index_formation_n3n4", name="index_formation_n3n4")
     */
    public function index()
    {
        return $this->render('pages/index_formation_N3N4.html.twig');
    }
}
