<?php

namespace App\Controller\Intranet;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexMaterielController extends Controller
{
    /**
     * @Route("/materiel/index_demande_emprunt", name="index_demande_emprunt")
     */
    public function indexDemandeEmprunt()
    {
        return $this->render('');
    }

    /**
     * @Route("/materiel/index_admin_genmat", name="index_admin_genmat")
     */
    public function indexAdminGenMat()
    {
        return $this->render('');
    }
}
