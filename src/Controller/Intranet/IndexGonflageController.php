<?php

namespace App\Controller\Intranet;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexGonflageController extends Controller
{
    /**
     * @Route("/gonflage/index_modif_gonf_eleves", name="index_modif_gonf_eleves")
     */
    public function indexModifGonfEleves()
    {
        return $this->render('');
    }

    /**
     * @Route("/gonflage/index_status_gonflage_eleves", name="index_status_gonflage_eleves")
     */
    public function indexStatusGonflageEleves()
    {
        return $this->render('');
    }
}
