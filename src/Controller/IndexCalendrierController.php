<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexCalendrierController extends AbstractController
{
    /**
     * @Route("/index_calendrier", name="index_calendrier")
     */
    public function index()
    {
        return $this->render('pages/index_calendrier.html.twig');
    }
}
