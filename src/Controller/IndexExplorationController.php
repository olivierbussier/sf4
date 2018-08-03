<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexExplorationController extends Controller
{
    /**
     * @Route("/index_exploration", name="index_exploration")
     */
    public function index()
    {
        return $this->render('pages/index_exploration.html.twig', [
            'controller_name' => 'IndexExplorationController',
        ]);
    }
}
