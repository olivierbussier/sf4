<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexTarifsController extends Controller
{
    /**
     * @Route("/index_tarifs", name="index_tarifs")
     */
    public function index()
    {
        return $this->render('pages/index_tarifs.html.twig');
    }
}
