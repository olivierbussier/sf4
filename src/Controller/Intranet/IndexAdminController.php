<?php

namespace App\Controller\Intranet;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Adherent;
use Symfony\Bridge\Doctrine\RegistryInterface;


class IndexAdminController extends Controller
{
    /**
     * @Route("/intranet/index_admin_affiche_perso", name="index_admin_affiche_perso")
     */
    public function affiche_perso()
    {
        return $this->render('intranet/index_affiche_perso.html.twig');
    }

    /**
     * @Route("/intranet/index_admin_trombi", name="index_admin_trombi")
     */
    public function trombi(RegistryInterface $doctrine)
    {
        $photos = $doctrine->getRepository(Adherent::class)->getAllPhotos();

        return $this->render('intranet/index_trombi.html.twig',[
            'photos' => $photos
        ]);
    }

    /**
     * @Route("/intranet/index_admin_calendrier", name="index_admin_calendrier")
     */
    public function adminCalendrier()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/index_admin_status_inscriptions", name="index_admin_status_inscriptions")
     */
    public function adminStatusInscription()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/index_liste_secouristes", name="index_secouristes")
     */
    public function listeSecouristes()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/index_liste_TIV", name="index_TIV")
     */
    public function listeTIV()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/admin_listes_diffusion", name="admin_listes_diffusion")
     */
    public function adminListesDiffusion()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/admin_export_trombi", name="admin_export_trombi")
     */
    public function adminExportTrombi()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/admin_droits_utilisateur", name="admin_droits")
     */
    public function adminDroits()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/admin_gen_excel/full", name="admin_gen_excel_full")
     */
    public function adminGenExcelFull()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/admin_gen_excel/inscrits", name="admin_gen_excel_inscrits")
     */
    public function adminGenExcelInscrits()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/admin_info_server/php", name="admin_info_server_php")
     */
    public function adminInfoPHP()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/admin_info_server/mysql", name="admin_info_server_mysql")
     */
    public function adminInfoMySQL()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/admin_log/mysql", name="admin_log_mysql")
     */
    public function adminLogMysql()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/admin_log/reset_log_mysql", name="admin_reset_log_mysql")
     */
    public function adminResetLogMysql()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/admin_log/mail", name="admin_log_mail")
     */
    public function adminLogMail()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/admin_log/intranet", name="admin_log_intranet")
     */
    public function adminResetLogMyssql()
    {
        return $this->render('');
    }
}
