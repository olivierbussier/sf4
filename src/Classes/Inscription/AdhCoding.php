<?php

namespace App\Classes\Inscription;

class AdhCoding
{
    public static function getRandomValID()
    {
        $db = Globals::getDb();

        // constitution de l'identifiant reduction famille:
        //  - 6 digits décimaux suivis de 2 digits hexa de chechsum
        while (1) {
            $random = hexdec(rand(0, 9999));
            $crc = substr(dechex(crc32($random)), 0, 2);
            $val = strtolower($random . $crc);
            $res = $db->query("select LOWER(REDUCFAMID) from @#@liste where REDUCFAMID = '$val'");
            if ($db->numrows($res) != 0) {
                // Existe déjà
                continue;
            }
            return $val;
        }
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