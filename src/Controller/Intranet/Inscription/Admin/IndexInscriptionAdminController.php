<?php


namespace App\Controller\Intranet\Inscription\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class IndexInscriptionAdminController extends AbstractController
{

    /**
     * @Route("/intranet/index_admin_status_inscriptions", name="index_admin_status_inscriptions")
     */
    public function adminStatusInscription()
    {
        return $this->render('');
    }


}
