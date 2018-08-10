<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexFormationN1Controller extends Controller
{
    /**
     * @Route("/index_formation_n1", name="index_formation_n1")
     */
    public function index()
    {
        return $this->render('pages/index_formation_N1.html.twig');
    }
}
