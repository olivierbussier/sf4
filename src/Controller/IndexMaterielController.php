<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexMaterielController extends Controller
{
    /**
     * @Route("/index_materiel", name="index_materiel")
     */
    public function index()
    {
        return $this->render('pages/index_materiel.html.twig');
    }
}
