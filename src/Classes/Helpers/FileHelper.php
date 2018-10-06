<?php

namespace App\Classes\Helpers;


use App\Classes\Config\Config;

class FileHelper
{
    const ORIGINALE_PREFIX = 'or';
    const THUMBNAIL_PREFIX = 'th';
    const DESC_OPER_PREFIX = 'do';

    const ORIGINAL   = 1;
    const THUMBNAIL  = 2;
    const OPERATIONS = 3;

    public static function getExt($file)
    {
        $ret = '';
        $m = mime_content_type($file);
        switch ($m) {
            case 'image/jpeg':
                $ret = 'jpg';
                break;
            case 'image/png':
                $ret = 'png';
                break;
            case 'image/gif':
                $ret = 'gif';
                break;
            case 'application/pdf':
                $ret = 'pdf';
                break;
        }
        return $ret;
    }

    /**
     * Teste si une des 3 images possible existe
     * Retourne false ou le 1er fichier trouvé
     * @param string $photo
     * @return string|bool
     */
    public static function photoExist(string $photo)
    {
        if (file_exists($photo.".jpg")) {
            return $photo.".jpg";
        }
        if (file_exists($photo.".png")) {
            return $photo.".png";
        }
        if (file_exists($photo.".gif")) {
            return $photo.".gif";
        }
        return false;
    }

    /**
     * @param string $path
     * @return string
     */
    public static function corrigerPath(string $path): string
    {
        // remplacer caracteres bizarres par '_'
        $path = preg_replace("#\\'#", "_", $path);
        $path = preg_replace("#é#", "_", $path);
        $path = preg_replace("#è#", "_", $path);
        $path = preg_replace("#à#", "_", $path);
        $path = preg_replace("#ç#", "_", $path);
        $path = preg_replace("#ù#", "_", $path);
        $path = preg_replace("#ë#", "_", $path);
        $path = preg_replace("# #", "_", $path);
        return $path;
    }

    /**
     * @param string $NOM
     * @param string $PRENOM
     * @param string $REF
     * @param int $TYPE
     * @return string
     */
    public static function initPathPhoto(string $NOM, string $PRENOM, string $REF, int $TYPE): string
    {
        switch ($TYPE) {
            case self::ORIGINAL:
                $mod = self::ORIGINALE_PREFIX;
                $ext = '.jpg';
                break;
            case self::THUMBNAIL:
                $mod = self::THUMBNAIL_PREFIX;
                $ext = '.jpg';
                break;
            case self::OPERATIONS:
                $mod = self::DESC_OPER_PREFIX;
                $ext = '.txt';
                break;
            default:
                echo "Error : $TYPE";
                $mod = '';
                $ext = '';
                break;
        }
        return self::corrigerPath(Config::$path_photo . $NOM . "-" . $PRENOM . "-" . $REF . '-' . $mod . $ext);
    }

    /**
     * @param string $photo
     * @return string
     */
    public static function photoTest(string $photo): string
    {
        if ($photo != false) {
            // Verif du format
            $sz=getimagesize($photo);
            if ($sz == false) {
                $status = "MAUVAIS_FORMAT";
            } else {
                if ($sz[0]!=240 || $sz[1]!=310) {
                    $status = "TAILLE_KO";
                } else {
                    $status = "OK";
                }
            }
        } else {
            $status = "INEXISTANTE";
        }
        return $status;
    }

    public static function delete($baseDir, $type, $nom, $prenom, $ref, $file)
    {
        switch ($type) {
            case 'certifs':
                $pathType = $baseDir . '/' . Config::$path_certif;
                $extBase = 'certifs';
                break;
            case 'diplomes':
                $pathType = $baseDir . '/' . Config::$path_diplome;
                $extBase = 'diplomes';
                break;
            case 'photos':
                $pathType = $baseDir . '/' . Config::$path_photo;
                $extBase = 'th';
                break;
        }

        $fileBase = self::corrigerPath($nom . '-' . $prenom);

        $pathSrc = $pathType . '/' . $fileBase . '-' . $ref . '-' . $extBase . '*.*';
        $files = glob($pathSrc);
        foreach ($files as $v) {
            if ($v != $file) {
                unlink($v);
            }
        }
    }
}
