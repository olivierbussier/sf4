<?php

namespace App\Classes\Inscription;

use App\Classes\Config\Config;

class AdhCoding
{
    public static function getRandomValID($userId)
    {
        // constitution de l'identifiant reduction famille:
        //  - 6 digits décimaux suivis de 2 digits hexa de chechsum
        $random = $userId + Config::$p_annee + 4587;
        $crc = substr(dechex(crc32($random)), 0, 2);
        $val = strtolower($random . $crc);
        return $val;
    }

    public static function checkValID($id)
    {
        $val = strtolower($id);
        $adh = substr($val, 0, strlen($val) - 2);
        $chk = substr($val, strlen($val) - 2, 2);
        $crc = substr(dechex(crc32($adh)), 0, 2);
        if ($chk == $crc) {
            $r = dechex($adh);
            if (is_numeric($r)) {
                return $r;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}