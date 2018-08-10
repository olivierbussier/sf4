<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexFormationN2Controller extends Controller
{
    /**
     * @Route("/index_formation_n2", name="index_formation_n2")
     */
    public function index()
    {
        return $this->render('pages/index_formation_N2.html.twig');
    }
}
