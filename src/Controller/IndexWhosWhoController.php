<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexWhosWhoController extends Controller
{
    /**
     * @Route("/index_whoswho", name="index_whoswho")
     */
    public function index()
    {
        return $this->render('pages/index_whoswho.html.twig', [
            'controller_name' => 'IndexWhosWhoController',
        ]);
    }
}
