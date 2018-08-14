<?php

namespace App\Controller\Inscription;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class IndexInscriptionController extends Controller
{
    /**
     * @Route("/inscription/index", name="index_inscription")
     */
    public function index()
    {
        return $this->render('inscription/index_inscription.html.twig');
    }

    /**
     * @Route("/inscription/administration", name="admin_inscription_administration")
     */
    public function administrationInscriptions()
    {
        return $this->render('');
    }

    /**
     * @Route("/inscription/reset_base_inscription", name="admin_reset_base_inscription")
     */
    public function resetBaseInscription()
    {
        return $this->render('');
    }

    /**
     * @Route("/inscription/reset_cheque_caution", name="admin_reset_cheque_caution")
     */
    public function resetChequeCaution()
    {
        return $this->render('');
    }
}
