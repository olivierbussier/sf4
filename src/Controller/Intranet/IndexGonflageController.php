<?php

namespace App\Controller\Intranet;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexGonflageController extends AbstractController
{
    /**
     * @Route("/gonflage/modif_eleves", name="index_modif_gonf_eleves")
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
