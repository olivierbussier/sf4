<?php

namespace App\Controller\Intranet\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexAdminController extends AbstractController
{
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
