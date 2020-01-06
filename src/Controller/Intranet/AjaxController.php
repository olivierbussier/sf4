<?php

namespace App\Controller\Intranet;

use App\Classes\Config\Config;
use App\Classes\Helpers\FileHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController extends AbstractController
{
    /**
     * @Route("/intranet/ajax/info_perso/upload", name="certif_ajax_upload")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function upload(EntityManagerInterface $em)
    {
        $type = $_POST['Type'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $id = $_POST['id'];

        $baseDir = Globals::getBaseDir();

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
            }

            $fxn = pathinfo($fn . '.' . $ext, PATHINFO_BASENAME);

            $typFile = FileHelpers::getType($baseDir . '/' . $path . $fxn);

            $json = [];
            //$json['error'] = '';

            $host = Globals::getHost();
            $ip = "$host/$path$fxn?r=" . rand(1, 9999999);

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
            echo $res;
        }
        if (count($_FILES) == 0) {
            echo '{}';
        }
        }

    /**
     * @Route("/intranet/ajax/info_perso/delete", name="certif_ajax_delete")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function delete(EntityManagerInterface $em)
    {
    }
}
