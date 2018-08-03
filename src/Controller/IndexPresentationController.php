<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexPresentationController extends Controller
{
    /**
     * @Route("/index_presentation", name="index_presentation")
     */
    public function index()
    {
        return $this->render('pages/index_presentation.html.twig', [
            'controller_name' => 'IndexPresentationController',
        ]);
    }
}
