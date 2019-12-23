<?php

namespace App\Controller\Intranet\Inscription;

use App\Classes\Config\Config;
use App\Classes\Form\FormConst;
use App\Classes\Helpers\DateHelper;
use App\Classes\Helpers\FileHelper;
use App\Classes\Inscription\AdhCoding;
use App\Classes\Inscription\Calculate;
use App\Classes\Inscription\CreatePDF;
use App\Entity\User;
use App\Form\InscriptionType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexInscriptionController extends AbstractController
{
    /**
     * @Route("/inscription/form/{slug}", name="inscription")
     * @param Request $request
     * @param ObjectManager $manager
     * @param string $slug
     * @return Response
     */
    public function index(Request $request, ObjectManager $manager, string $slug = 'Normal')
    {
        /** @var User $user */
        $user2 = $manager->getRepository('App\\Entity\\User')->find(410);
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
        /** @var User $user */
        $user = $this->getUser();

        $l = new Calculate();

        /** @var Error $e Créée par le script appelant */

        $cotis = $l->calcCotis($user);
        $axa   = $l->calcAxa($user->getAssurance());

        // Calcul Cotisation

        $mytotal    = $cotis['prixCotis'] + $cotis['prixLicence'] - $cotis['prixReduc'] - $cotis['prixRemb'];         // Montant cotisation
        $mytotalass = $axa  ['prixAxa' ];                               // Montant assurance
        $fbene      = $cotis['fBene'];         // Bénévole
        $fenc       = $cotis['fEnc'];          // Encadrant actif

        $age_today = DateHelper::age($user->getDateNaissance()->format('Y-m-d'));

        // Génération du PDF

        // Initialisation de ces variables pour pointer correctement le path du fichier généré
        // selon que l'on à affaire à un lien dans une page HTML ($path).
        // Ou un lien dans un mail ($path_mail)
        // ------------------------------------------------------------------------------------

        $tronc = $user->getNom()."-".$user->getPrenom()."-".$user->getId();
        $path_corr   = FileHelper::corrigerPath(Config::path_fiches);
        $path_adher  = FileHelper::corrigerPath($tronc.".pdf");
        $path_livret = FileHelper::corrigerPath("../docs/livret_accueil_GUC.pdf");

        $path_ident = FileHelper::initPathPhoto(
            $user->getNom(), $user->getPrenom(), $user->getId(), FileHelper::THUMBNAIL
        );

        (new CreatePDF())->createPDF(
            $user,
            $path_corr.$path_adher,
            $path_ident,
            $mytotal,
            $mytotalass
        );


        return $this->render('inscription/index_inscription_fin.html.twig', [
            'Activite' => $user->getActivite(),
            'refPP'    => 0,
            'age'      => $age_today,
            'photo'    => 'KO',
            'total'    => $mytotal,
            'totalass' => $mytotalass
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
