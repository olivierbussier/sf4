<?php

namespace App\Classes\Helpers;


use App\Classes\Config\Config;

class FileHelper
{
    const ORIGINALE_PREFIX = 'or';
    const THUMBNAIL_PREFIX = 'th';

    const ORIGINAL   = 1;
    const THUMBNAIL  = 2;

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
        return self::corrigerPath(
            '/' . Config::path_photo . $NOM . "-" . $PRENOM . "-" . $REF . '-th.jpg'
        );
    }

    public static function delete($baseDir, $type, $nom, $prenom, $ref, $file)
    {
        switch ($type) {
            case 'certifs':
                $pathType = $baseDir . '/' . Config::path_certif;
                $extBase = 'certifs';
                break;
            case 'diplomes':
                $pathType = $baseDir . '/' . Config::path_diplome;
                $extBase = 'diplomes';
                break;
            case 'photos':
                $pathType = $baseDir . '/' . Config::path_photo;
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

    /**
     * @param string $type
     * @param string $nom
     * @param string $prenom
     * @param int $refUser
     * @return array|false
     */
    public function getFiles(string $type, string $nom, string $prenom, int $refUser)
    {
        $type = strtolower($type);
        switch ($type) {
            case 'certif':
                $path = Config::path_certif;
                break;
            case 'diplomes':
                $path = Config::path_diplome;
                break;
        }

        $file = self::corrigerPath($nom . '.' . $prenom);

        $file = "uploads/certifs/" . $file . "*";
        $rep = getcwd();
        $tabFiles = glob($file);
        return $tabFiles;
    }

    /**
     * Construire le repertoire
     * @param $type
     * @return string
     */
    public static function constructDirName($type)
    {
        $rep = getcwd() . '/' . $type;
        return $rep;
    }

    /**
     * Construire la base d'un nom de fichiers
     * @param $nom
     * @param $prenom
     * @param $id
     * @return mixed
     */
    public static function constructFileName($nom, $prenom, $id)
    {
        $new = self::corrigerPath($nom .'.'. $prenom) . '.' . $id;
        return $new;
    }

    /**
     * Recherche d'un nom de fichier disponible
     * la fonction retourne false si le nombre max de fichiers est atteint
     * ou retourne un numéro de fichier libre
     * @param $nom
     * @param $prenom
     * @param $id
     * @return string
     */
    public static function getAvailableName($nom, $prenom, $id, $type)
    {
        $rep  = self::constructDirName($type);
        $file = self::constructFileName($nom, $prenom, $id);
        $res = glob($rep. '/' . $file . '*');

        if ($res == null) {
            // Aucun fichier
            return $rep . $file . '.1';
        } else {
            foreach ($res as $k => $v) {
                $f = pathinfo($v, PATHINFO_FILENAME);
                $decomp = explode('.', $f);
                $num = intval($decomp[3]);
                $tabFiles[$num] = $num;
            }
            $i=1;
            foreach ($tabFiles as $k => $v) {
                if ($i < $k) {
                    break;
                } else {
                    $i++;
                }
            }
            return $rep . $file . '.' . $i;
        }
    }
}
