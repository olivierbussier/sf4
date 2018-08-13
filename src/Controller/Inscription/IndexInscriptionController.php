<?php

namespace App\Controller\Inscription;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class IndexInscriptionController extends Controller
{
    /**
     * @Route("/inscription/index", name="index_inscription")
     */
    public function index()
    {
        return $this->render('inscription/index_inscription.html.twig');
    }
}
