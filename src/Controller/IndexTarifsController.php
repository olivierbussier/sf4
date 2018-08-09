<?php

namespace App\Controller;

use App\Classes\Config;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexTarifsController extends Controller
{
    /**
     * @Route("/index_tarifs", name="index_tarifs")
     */
    public function index()
    {
        $cl = new \ReflectionClass('App\Classes\Config');
        $tt = $cl->getConstants();

        return $this->render('pages/index_tarifs.html.twig', [
            'controller_name' => 'IndexTarifsController',
            'Config' => $tt,
            'xxannee' => $this->getParameter('app.p_annee')
        ]);
    }
}
