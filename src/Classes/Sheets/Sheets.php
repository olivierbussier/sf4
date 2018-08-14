<?php

namespace App\Classes\Sheets;

use Exception;
use Google_Client;
use Google_Exception;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;

class Sheets
{
    const APPLICATION_NAME   =  'Google Sheets API PHP Quickstart';
    const CREDENTIALS_PATH   =  __DIR__ . '/.credentials/sheets.googleapis.com-php-quickstart.json';
    const CLIENT_SECRET_PATH =  __DIR__ . '/client_secret.json';

    private $dates = [];
    private $values = [];

    const SPREADSHEETID = "15hIBOg4lAjBHpE27OdTk_S9TxsXw8xtjpUarfIaM9tI";
    const SPREADSHEETNAME = "https://docs.google.com/spreadsheets/d/".self::SPREADSHEETID."/edit";
    private $range = "Feuil1!A4:H60";
    private $client = false;
    private $service;

    private $scope = [
        Google_Service_Sheets::SPREADSHEETS
    ];

    /**
     * @return string
     */
    public static function getSheetURL(): string
    {
        return self::SPREADSHEETNAME;
    }

    /**
     * Sheets constructor.
     */
    public function __construct()
    {
        try {
            $this->client = $this->getClient();
            $this->service = new Google_Service_Sheets($this->client);
        } catch (Google_Exception $e) {
            //echo '<pre>';
            //var_dump($e);
            //exit;
        }
    }

    /**
     * Returns an authorized API client.
     * @return Google_Client the authorized client object
     * @throws Google_Exception
     */
    public function getClient()
    {
        $client = new Google_Client();
        $client->setApplicationName(self::APPLICATION_NAME);
        $client->setScopes($this->scope);
        $client->setAuthConfig(self::CLIENT_SECRET_PATH);
        $client->setAccessType('offline');

        // Load previously authorized credentials from a file.
        $credentialsPath = $this->expandHomeDirectory(self::CREDENTIALS_PATH); // echo $credentialsPath;
        if (file_exists($credentialsPath)) {
            $accessToken = file_get_contents($credentialsPath);
        }
        $client->setAccessToken($accessToken);

        // Refresh the token if it's expired.
        if ($client->isAccessTokenExpired()) {
            $client->refreshToken($client->getRefreshToken());
            file_put_contents(
                $credentialsPath,
                json_encode($client->getAccessToken())
            );
        }
        return $client;
    }

    /**
     * Expands the home directory alias '~' to the full path.
     * @param string $path the path to expand.
     * @return string the expanded path.
     */
    public function expandHomeDirectory($path)
    {
        $homeDirectory = getenv('HOME');
        if (empty($homeDirectory)) {
            $homeDirectory = getenv("HOMEDRIVE") . getenv("HOMEPATH");
        }
        return str_replace('~', realpath($homeDirectory), $path);
    }

    /**
     *
     */
    public function updateValues()
    {
        $response = $this->service->spreadsheets_values->get(self::SPREADSHEETID, $this->range);
        $this->values = $response->getValues();
    }

    /**
     * Recherche des dispos
     * @return array
     */
    public function construireTableDates()
    {
        $this->updateValues();

        $this->dates = [];
        foreach ($this->values as $row) {
            if (!isset($this->dates[$row[0]])) {
                $this->dates[$row[0]]['pris'] = 0;
                $this->dates[$row[0]]['dispo'] = 0;
                $this->dates[$row[0]]['lieu'] = $row[7];
            }
            $this->dates[$row[0]]['dispo']++;
            if (@$row[1] != "") {
                $this->dates[$row[0]]['pris']++;
            }
        }
        return $this->dates;
    }

    /**
     * Recherche du nombre de slots libres pour une date
     * @param $date
     * @return bool
     */
    public function getFreeSlots($date)
    {
        $this->construireTableDates();

        foreach ($this->dates as $d => $n) {
            if ($d == $date) {
                return $n['dispo'] - $n['pris'];
            }
        }
        return false; // Date non trouvée
    }

    /**
     * Retourne un numéro de ligne vide pour une date
     * @param $date
     * @return int
     */
    public function getFreeDate($date)
    {
        //global $response, $values;

        $this->updateValues();
        $ligne = 4;
        foreach ($this->values as $row) {
            if (($row[0] == $date) && ((!isset($row[1])) || $row[1] == "")) {
                return $ligne;
            }
            $ligne++;
        }
        return 0;
    }

    /**
     * @param string $date
     * @param string $prenom
     * @param string $nom
     * @param string $sexe
     * @param string $age
     * @param string $pointure
     * @param string $taille
     * @param string $mail
     * @return bool
     */
    public function fillOneSlot(
        string $date,
        string $prenom,
        string $nom,
        string $sexe,
        string $age,
        string $pointure,
        string $taille,
        string $mail
    ) {
        $ligne = $this->getFreeDate($date);

        if ($ligne == 0) {
            return false;
        }


        $range = "Feuil1!B" . $ligne . ":G" . $ligne;
        $vRan = new Google_Service_Sheets_ValueRange();
        $vRan->setMajorDimension("ROWS");
        $vRan->setRange($range);
        $vRan->setValues([[$prenom . " " . $nom, $sexe, $age, $pointure, $taille, $mail]]);
        $this->service->spreadsheets_values->update(
            self::SPREADSHEETID,
            $range,
            $vRan,
            ["valueInputOption" => "USER_ENTERED"]
        );
        return true;
    }
}