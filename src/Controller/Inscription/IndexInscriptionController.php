<?php

namespace App\Controller\Inscription;

use App\Classes\Form\FormConst;
use App\Entity\Adherent;
use App\Form\InscriptionType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class IndexInscriptionController extends Controller
{
    /**
     * @Route("/inscription/index", name="index_inscription")
     */
    public function index()
    {
        $user = $this->getUser();

        $form = $this->createForm(InscriptionType::class, $user);

        /*if (($valReducFam = Form::get('REDUCFAMID')) == '') {
            // Génération d'un ID et sauvegarde
            $valReducFam = AdhCoding::getRandomValID();
            Form::set('REDUCFAMID', $valReducFam);
        }*/

        return $this->render('inscription/index_inscription_page.html.twig',[
            'fPassager' => false,
            'licenceMode' => FormConst::INSCR_NORMAL,
            'formInscr' => $form->createView(),
            'fGood'     => true,
            'fileName'  => 'xx/a.jpg',
            'refPhoto'  => 411,
            'fileDiplomes' => [
                ['name' => 'a.jpg', 'type' => 'image'],
                ['name' => 'b.jpg', 'type' => 'image'],
                ['name' => 'c.jpg', 'type' => 'image'],
                ['name' => 'd.jpg', 'type' => 'image']
            ],
            'fileCertif' => [
                ['name' => 'c.jpg', 'type' => 'image']
            ],
            'ReducFamId' => '123456ff'
        ]);
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
