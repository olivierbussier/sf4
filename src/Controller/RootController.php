<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RootController extends Controller
{
    /**
     * @Route("/", name="root")
     */
    public function index()
    {
        return $this->render('pages/index.html.twig', [
            'controller_name' => 'RootController',
        ]);
    }
}
