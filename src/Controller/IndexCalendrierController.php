<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexCalendrierController extends Controller
{
    /**
     * @Route("/index_calendrier", name="index_calendrier")
     */
    public function index()
    {
        return $this->render('pages/index_calendrier.html.twig');
    }
}
