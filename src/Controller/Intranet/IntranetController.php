<?php

namespace App\Controller\Intranet;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IntranetController extends Controller
{
    /**
     * @Route("/intranet/index", name="index_intranet")
     */
    public function index()
    {
        return $this->render('intranet/index.html.twig', [
            'controller_name' => 'IntranetController',
        ]);
    }
}
