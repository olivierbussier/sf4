<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexGonflageController extends Controller
{
    /**
     * @Route("/index_gonflage", name="index_gonflage")
     */
    public function index()
    {
        return $this->render('pages/index_gonflage.html.twig');
    }
}
