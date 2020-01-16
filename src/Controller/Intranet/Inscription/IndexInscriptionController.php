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
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexInscriptionController extends AbstractController
{
    /**
     * @Route("/inscription/form/{slug}", name="inscription")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param string $slug
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $em, string $slug = 'Normal')
    {
        /** @var User $user */
        $user2 = $em->getRepository('App\\Entity\\User')->find(410);
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

        // Liste des fichiers de diplomes
        $diplomes = FileHelper::getFilesTypes(
            FileHelper::getFiles('diplomes', $user->getNom(), $user->getPrenom(), $user->getId())
        );

        // Liste des fichiers de certif
        $certif = FileHelper::getFilesTypes(
            FileHelper::getFiles('certif', $user->getNom(), $user->getPrenom(), $user->getId())
        );

        $user->setConfirmPassword($user->getPassword());

        $form = $this->createForm(InscriptionType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $fValid = $form->isValid();

            // On enregister quoi qu'il en soit les saisies de l'adhérent

            $em->persist($user);
            $em->flush();

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
            'fileDiplomes' => $diplomes,
            'fileCertif'   => $certif,
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
     * @Route("/inscription/ajax_file_upload", name="ajax_file_upload")
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxFileUpload(Request $request): JsonResponse
    {
        $type    = $_POST['Type'];
        $nom     = $_POST['nom'];
        $prenom  = $_POST['prenom'];
        $id      = $_POST['id'];

        $baseDir = getcwd();
        $host = $request->getHttpHost();
        /*
         * Gestion du certificat
         * - Les documents chargés par l'utilisateur (soit a l'inscription, soit dans l'espace perso) ont pour
         *   nom de fichier est <nom>-<prenom>-<id>-new.ext
         * - Ce document est validé par l'administrateur,
         *   le nom devient alors <nom>-<prenom>-<id>-valide.ext
         *
         * Gestion des diplomes
         * - 4 documents peuvent être chargés par l'utilisateur
         * - Le nom de ces documents est <nom>-<prenom>-<id>-{1/2/3/4}.ext
         *
         */
        switch ($type) {
            case Config::$suffix_ncertif:
            case Config::$suffix_certif:
                $path = Config::path_certif;
                $fn = $baseDir . '/' . $path . FileHelper::corrigerPath($nom . '.' . $prenom) . '.' . $id . '.new';
                break;
            case Config::$suffix_diplome:
                $path = Config::path_diplome;
                $fn = FileHelper::getAvailableName($nom, $prenom, $id, Config::path_diplome);
                break;
            default:
                exit;
        }

        foreach ($_FILES as $file) {
            $ext = FileHelper::getExt($file['tmp_name'][0]);
            $sFileTemp = $file['tmp_name'][0];

            $newFile = $fn . '.' . $ext;

            move_uploaded_file($sFileTemp, $newFile);

            if ($type == Config::$suffix_ncertif) {
                // Envoi du mail vers la liste 'certif' pour signaler un changement de certificat
                // ------------------------------------------------------------------------------

                $sujet = $_SESSION['NOM'] . ' ' . $_SESSION['PRENOM'] . ' - changement de certificat médical';

                $body = "<html><head></head><body><p>" . $_POST['nom'] . ' ' .
                    $_POST['prenom'] . "a chargé un nouveau fichier de certificat médical</p></body></html>";
/*
                $ml = new MailMime();

                $ml->init(
                    MailUsers::$from_certif,
                    MailUsers::$dest_certif,
                    $sujet
                );
                $ml->setDkimSign(true);
                $text = (new HtmlToTxt)->html2txt($body);
                $ml->addAlternative($text, $body);
                $ml->addFile(
                    Globals::getBaseDir() . '/' . Config::$path_certif,
                    pathinfo($newFile, PATHINFO_BASENAME)
                );
                $ml->send();
*/
            }

            $fxn = pathinfo($fn . '.' . $ext, PATHINFO_BASENAME);

            $typFile = FileHelper::getExt($baseDir . '/' . $path . $fxn);

            $json = [];
            //$json['error'] = '';

            $ip = "$host$path$fxn?r=" . rand(1, 9999999);

            $json['initialPreview'][] = $ip;

            $ipc = [];
            $ipc['type'] = $typFile;
            //$ipc['initialPreviewAsData'] = true;
            if ($type == Config::$suffix_ncertif && strstr($fxn, '.new')) {
                $ipc['showRemove'] = true;
                $ipc['caption'] = "<span class='yellow'>Nouveau certificat</span>";
            } else {
                $ipc['caption'] = $fxn;
            }
            $ipc['width'] = '120px';

            $ipc['key'] = "$path$fxn";

            $json['initialPreviewConfig'][] = $ipc;

            $res = json_encode($json, JSON_UNESCAPED_SLASHES);
            return new JsonResponse($res);
        }
        if (count($_FILES) == 0) {
            return new JsonResponse('{}');
        }
    }

    /**
     * @Route("/inscription/ajax_file_delete", name="ajax_file_delete")
     */
    public function ajaxFileDelete()
    {
        $type    = $_POST['Type'];
        $nom     = $_POST['nom'];
        $prenom  = $_POST['prenom'];
        $id      = $_POST['id'];

        $base = getcwd();

        switch ($type) {
            case Config::$suffix_ncertif:
            case Config::$suffix_certif:
                $path = Config::path_certif;
                break;
            case Config::$suffix_diplome:
                $path = Config::path_diplome;
                break;
            default:
                exit;
        }

        if (isset($_POST['key']) && file_exists($base . $path . $_POST['key'])) {
            $key = $_POST['key'];
            unlink($base . $path . $key);
            return new JsonResponse('{}');
        } else {
            return new JsonResponse('{err}');
        }
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
