<?php

namespace App\Controller\Inscription;

use App\Classes\Form\FormConst;
use App\Classes\Inscription\AdhCoding;
use App\Entity\Adherent;
use App\Form\InscriptionType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class IndexInscriptionController extends Controller
{
    /**
     * @Route("/inscription/form/{slug}", name="inscription")
     * @param Request $request
     * @param ObjectManager $manager
     * @param string $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, ObjectManager $manager, string $slug = 'Normal')
    {
        /** @var Adherent $user */
        $user2 = $manager->getRepository('App\\Entity\\Adherent')->find(410);
        $user = $this->getUser();

        if ($slug == 'normal') {
            $inscrType = FormConst::INSCR_NORMAL;
        } elseif ($slug == 'passager') {
            $inscrType = FormConst::INSCR_PASSAGER;
        } else {
            return $this->redirectToRoute('root');
        }

        $user->setInscrType($inscrType);

        // Calcul de l'ID reducfam s'il n'esiste pas

        if (($valReducFam = $user->getReducFamilleID()) == '') {
            // Génération d'un ID et sauvegarde
            $valReducFam = AdhCoding::getRandomValID($user->getId());
            $user->setReducFamilleID($valReducFam);
        }

        $user->setConfirmPassword($user->getPassword());

        $form = $this->createForm(InscriptionType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $fValid = $form->isValid();

            // On enregister quoi qu'il en soit les saisies de l'adhérent

            $manager->persist($user);
            $manager->flush();

            if ($fValid) {
                return $this->redirectToRoute('recap_inscription');
            }
        }

        return $this->render('inscription/index_inscription_page.html.twig',[
            'formInscr' => $form->createView(),
            'inscrType' => $inscrType,
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
            'ReducFamId' => $valReducFam
        ]);
    }

    /**
     * @Route("/inscription/recap", name="recap_inscription")
     */
    public function recapInscription()
    {
        /** @var Adherent $user */
        $user = $this->getUser();

        return $this->render('inscription/index_inscription_fin.html.twig', [
            'Activite' => $user->getActivite(),
            'refPP'    => 0,
            'age'      => 17,
            'photo'    => 'KO',
            'total'    => 127,
            'totalass' => 89
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
