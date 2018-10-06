<?php
namespace App\Classes\Helpers;

use DateTime;

class DateHelper
{
    /**
     * Convertit une date au format YYYY-MM-DD au format DD/MM/YYYY
     * @param string $date
     * @return string
     */
    public static function dmg(string $date): string
    {
        $d = explode('-', $date);
        if (isset($d[1])) {
            return $d[2] . '/' . $d[1] . '/' . $d[0];
        } else {
            return "00/00/0000";
        }
    }

    /**
     * @param string $date
     * @return string
     */
    public static function dgm(string $date): string
    {
        $d = explode('/', $date);
        if (isset($d[1])) {
            return $d[2] . '-' . $d[1] . '-' . $d[0];
        } else {
            return "0000-00-00";
        }
    }

    /**
     * Convertit si besoin une date de la forme
     * JJ/MM/AAAA au format YYYY-MM-DD
     * Et vérifie ensuite que cette date est correcte
     * retour : 0 = OK, -1 = syntaxe date incorrect, -2 = date incorrecte
     *         -3, si fCheckToday == true et si la date est > aujourd'hui
     * @param string $Date
     * @param bool $fCheckToday
     * @return int
     */
    public static function verifDate(string $Date, bool $fCheckToday = true): int
    {
        if (strstr($Date, "-")) {
            $Date = self::dmg($Date);
        }

        if (preg_match(
            '/[0-9][0-9]\/[0-1][0-9]\/[1-2][0-9][0-9][0-9]/',
            $Date
        ) != 1 || strlen($Date) != 10) {
            return -1;
        }

        $dn = preg_split("/\/|-/", $Date, -1, PREG_SPLIT_NO_EMPTY);
        $jour = (int)$dn[0];
        $mois = (int)$dn[1];
        $annee = (int)$dn[2];

        if (!checkdate($mois, $jour, $annee)) {
            return -2;
        }

        if ($fCheckToday && $annee >= (int)date("Y")) {
            return -3;
        }

        return 0;
    }

    /**
     * Calcul de l'age en années à une date donnée
     * @param string $DateNaiss
     * @param string $Date
     * @return int
     */
    public static function age(string $DateNaiss, string $Date = null): int
    {
        if (strstr($DateNaiss, '-') == false) {
            $DateNaiss = self::dgm($DateNaiss);
        }
        if ($Date != null && strstr($Date, '-') == false) {
            $Date = self::dgm($Date);
        }

        $dn = new DateTime($DateNaiss);

        if ($Date == null) {
            $df = new DateTime('now');
        } else {
            $df = new DateTime($Date);
        }

        $interval = $df->diff($dn);

        return $interval->y;
    }

    /**
     * Calcul de l'age en jours a une date donnée
     * @param string $DateNaiss
     * @param string|null $Date
     * @return int
     */
    public static function ageinDays(string $DateNaiss, string $Date = null): int
    {
        if (strstr($DateNaiss, '-') == false) {
            $DateNaiss = self::dgm($DateNaiss);
        }
        if ($Date != null && strstr($Date, '-') == false) {
            $Date = self::dgm($Date);
        }

        $dn = new DateTime($DateNaiss);

        if ($Date == null) {
            $df = new DateTime('now');
        } else {
            $df = new DateTime($Date);
        }

        $interval = $df->diff($dn);

        return $interval->days;
    }

    /**
     * Calcul de l'age a la date du jour
     * @param string $DateNaiss
     * @return int
     */
    public static function ageAujourdhui(string $DateNaiss): int
    {
        return self::age($DateNaiss);
    }
}
