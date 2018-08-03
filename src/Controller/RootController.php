<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RootController extends Controller
{
    /**
     * @Route("/", name="root")
     * @throws \ReflectionException
     */
    public function index()
    {
        $cl = new \ReflectionClass('App\Classes\Config');
        $tt = $cl->getConstants();

        return $this->render('pages/index.html.twig', [
            'controller_name' => 'RootController',
            'Config' => $tt
        ]);
    }
}
