<?php

namespace App\Controller\Intranet\Materiel\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexMaterielAdminController extends AbstractController
{

    /**
     * @Route("/intranet/materiel/index_admin_genmat", name="index_admin_genmat")
     */
    public function indexAdminGenMat()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/materiel/admin_demandes", name="admin_demandes")
     */
    public function adminDemandes()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/materiel/admin_demandes_excel", name="admin_demandes_excel")
     */
    public function adminDemandesExcel()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/materiel/admin_calendrier_materiel", name="admin_calendrier_materiel")
     */
    public function adminCalendrierMateriel()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/materiel/admin_calendrier_adherent", name="admin_calendrier_adherent")
     */
    public function adminCalendrierAdherent()
    {
        return $this->render('');
    }
}
