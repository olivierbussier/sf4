<?php

class ConvertDatabase
{
    /**
     * @var array
     * @uses set_roles,json,create_password,nullable,integer,boolean,guc_date,create_username
     */
    private $correspAdherents = [
        "id"                    => ["Ref"           , "integer"],
        "username"              => [""              , "create_username"],
        "nom"                   => ["NOM"           , ""],
        "prenom"                => ["PRENOM"        , ""],
        "mail"                  => ["MAIL"          , ""],
        "roles"                 => [""              , "set_roles"],
        "liste_droits"          => ["DROITS"        , "json"],
        "code_secret"           => ["PASSWD"        , ""],
        "password"              => ["PASSWD"        , "create_password"],
        "genre"                 => ["GENRE"         , ""],
        "adresse1"              => ["ADD1"          , ""],
        "adresse2"              => ["ADD2"          , ""],
        "code_postal"           => ["CODEP"         , ""],
        "ville"                 => ["VILLE"         , ""],
        "profession"            => ["PROFESSION"    , ""],
        "date_naissance"        => ["DATENAISS"     , "myDate"],
        "lieu_naissance"        => ["LIEUNAISS"     , ""],
        "departement_naissance" => ["DEPTNAISS"     , ""],
        "tel_fix"               => ["TELFIX"        , ""],
        "tel_port"              => ["TELPORT"       , ""],
        "f_etudiant"            => ["ETUDIANT"      , "boolean"],
        "niveau_sca"            => ["NIVEAU"        , ""],
        "niveau_apn"            => ["APNEE"         , ""],
        "diplomes"              => ["DIPLOMES"      , "diplomes"],
        "f_apnee_sca"           => ["APNEESCA"      , "boolean"],
        "activite"              => ["ACTIVITE"      , ""],
        "f_benevole"            => ["BENEVOLE"      , "boolean"],
        "f_encadrant"           => ["ENCADRANT"     , "boolean"],
        "accident_nom"          => ["ACCNOM"        , ""],
        "accident_prenom"       => ["ACCPRENOM"     , ""],
        "accident_tel_fix"      => ["ACCTELFIX"     , ""],
        "accident_tel_port"     => ["ACCTELPORT"    , ""],
        "date_certif"           => ["DATECERTIF"    , "myDate"],
        "f_allerg_aspirine"     => ["ALERGASP"      , "boolean"],
        "licence"               => ["LICENCE"       , ""],
        "cotisation"            => ["COTISATION"    , ""],
        "f_carte_guc"           => ["CARTEGUC"      , "boolean"],
        "f_carte_siuaps"        => ["CARTESIUAPS"   , "boolean"],
        "f_mail_guc"            => ["MAILGUC"       , "boolean"],
        "f_trombi"              => ["FTROMBI"       , "boolean"],
        "envoi_guc"             => ["ENVOIGUC"      , ""],
        "envoi_siuaps"          => ["ENVOISIUAPS"   , ""],
        "facture"               => ["FACTURE"       , ""],
        "ref_facture"           => ["REFFACT"       , ""],
        "assurance"             => ["ASSURANCE"     , ""],
        "pret_materiel"         => ["PRETMAT"       , "boolean"],
        "pret_materiel_old"     => ["PRETMATOLD"    , "boolean"],
        "mineur_nom"            => ["MINNOM"        , ""],
        "mineur_prenom"         => ["MINPRENOM"     , ""],
        "mineur_qualite"        => ["MINQUAL"       , ""],
        "modif_user"            => ["MODIFUSER"     , ""],
        "date_modif_user"       => ["DATEMODIFUSER" , "myDate"],
        "date_prem_inscr"       => ["DATEPREMINSCR" , "myDate"],
        "admin_ok"              => ["ADMINOK"       , "json"],
        "comments"              => ["COMMENTS"      , ""],
        "reduc_famille_id"      => ["REDUCFAMID"    , ""],
        "reduc_fam"             => ["REDUCFAM"      , ""]
    ];

    private $correspBlogTextes = [
        "id"                    => ["Ref"           , "integer"],
        "posted_at"             => ["Date"          , "myDate"],
        "title"                 => ["Title"         , ""],
        "content"               => ["Texte"         , ""],
        "position"              => ["Ordre"         , "integer"],
        "link"                  => ["Link"          , ""],
        "position_image"        => ["PositionImage" , ""],
        "image"                 => ["RefImage"      , "getImage"]
    ];

    private $correspDiplomes = [
        "id"                    => ["Ref"           , "integer"],
        "user_id"               => [""              , "makeuser"],
        "type"                  => ["Texte"         , "maketype"],
        "date_obtention"        => ["DATEOBT"       , "myDate"],
        "date_recyclage"        => ["DATERECYCL"    , "myDate"],
        "numero"                => ["NUMERO"        , ""],
        "commentaire"           => ["COMMENTAIRE"   , ""]
    ];

    private $correspResultats = [
        "id"                    => ["Ref"           , "integer"],
        "annee_cross"           => ["annee_cross"   , "integer"],
        "course"                => ["course"        , "nonnul"],
        "classement"            => ["arrive"        , "integer"],
        "dossard"               => ["dossard"       , "integer"],
        "temps"                 => ["temps"         , "convertTemps"],
        "ecart"                 => ["ecart"         , "convertTemps"],
        //"vitesse"               => ["vitesse"       , ""],  // Calculé par convertTemps
        "nom"                   => ["nom"           , ""],
        "prenom"                => ["prenom"        , ""],
        "categorie"             => ["categorie"     , "categorie"],
        "sexe"                  => ["sexe"          , ""],
        "ville"                 => ["ville"         , ""]
    ];

    private $id = 0;
    private $sql = [];
    private $data = [];
    private $sqlLast = [];

    private $baseSrc;
    private $baseDst;

    private $translation = [
            'à' => 'a',            'á' => 'a',            'â' => 'a',            'ã' => 'a',            'ä' => 'a',
            'ç' => 'c',
            'è' => 'e',            'é' => 'e',            'ê' => 'e',            'ë' => 'e',
            'ì' => 'i',            'í' => 'i',            'î' => 'i',            'ï' => 'i',
            'ñ' => 'n',
            'ò' => 'o',            'ó' => 'o',            'ô' => 'o',            'õ' => 'o',            'ö' => 'o',
            'ù' => 'u',            'ú' => 'u',            'û' => 'u',            'ü' => 'u',
            'ý' => 'y',            'ÿ' => 'y',
            'À' => 'A',            'Á' => 'A',            'Â' => 'A',            'Ã' => 'A',            'Ä' => 'A',
            'Ç' => 'C',
            'È' => 'E',            'É' => 'E',            'Ê' => 'E',            'Ë' => 'E',
            'Ì' => 'I',            'Í' => 'I',            'Î' => 'I',            'Ï' => 'I',
            'Ñ' => 'N',
            'Ò' => 'O',            'Ó' => 'O',            'Ô' => 'O',            'Õ' => 'O',            'Ö' => 'O',
            'Ù' => 'U',            'Ú' => 'U',            'Û' => 'U',            'Ü' => 'U',
            'Ý' => 'Y'
    ];

    private $tabCat = [
        's'     => 'Senior',
        'v1'    => 'Vétéran1',
        'v2'    => 'Vétéran 2',
        'v3'    => 'Vétéran 3',
        'c'     => 'Cadet',
        'e'     => 'Espoir',
        'j'     => 'Junior',
        '0'     => '-',
        'v4'    => 'Vétéran 4',
        'se'    => 'Senior',
        'es'    => 'Espoir',
        'ca'    => 'Cadet',
        'ju'    => 'Junior',
        'senio' => 'Senior',
        'veter' => 'Vétéran',
        'junio' => 'Junior',
        'espoi' => 'Espoir',
        'cadet' => 'Cadet',
        'v5'    => 'Vétéran 5'
];
    /**
     * ConvertDatabase constructor.
     */
    public function __construct()
    {
        $this->baseSrc = new mysqli('localhost', 'root', '', 'adherents');
        $this->baseDst = new mysqli('localhost', 'root', '', 'sf4');

        $this->baseSrc->set_charset('utf8');
        $this->baseDst->set_charset('utf8');
    }

    /**
     * @param $field
     * @param $value
     */
    private function putSQL($field, $value)
    {
        $this->sql[$field] = $value;
    }

    /**
     * @param mysqli $m
     * @param $query
     */

    private function myQuery(mysqli $m, $query)
    {
        echo $query . "\n\n";
        if (!$m->query($query)) {
            echo "Erreur SQL : " . $m->error . "\n";
        }
    }

    /**
     * @param $field
     * @param $value
     * @return bool
     */
    private function diplomes($field, $value)
    {
        $dest_roles = [];
/*
        $res = $this->baseSrc->query("select * from preprod_diplomes");

        while($d = $res->fetch_assoc()) {

            foreach ($diplomes as $v) {
                $role = explode(':', $v);
                if ($role[1] == 'OUI') {
                    switch ($role[0]) {
                        case "T":    $dest_roles[] = 'TIV';             break;
                        case "FT":   $dest_roles[] = 'Formateur TIV';   break;
                        case "MF":   $dest_roles[] = 'Médecin fédéral'; break;
                        case "PA":   $dest_roles[] = 'Secouriste';      break;
                    }
                }
            }

        foreach ($dest_roles as $role) {
            $this->sqlLast[] = "insert into diplome set user_id = " . $this->id . ", type = '" . $d['TYPE'] ."'," .
                " date_obtention = '".$d['DATEOBT']."', date_recyclage = '".$d['DATERECYCL']."', numero = '".$d['NUMERO']."'";
        }
        return true;

            $query = "insert into diplome set user_id = " . $this->id . ", type = '" . $d['TYPE'] ."'," .
                " date_obtention = '".$d['DATEOBT']."', date_recyclage = '".$d['DATERECYCL']."', numero = '".$d['NUMERO']."'";
            $this->baseDst->query($query);
        }*/
        return true;
    }

    /**
     * @param $field
     * @param $value
     * @return bool
     */
    private function nonnul($field, $value)
    {
        if (is_string($value)) {
            if ($value == '') {
                return false;
            } else {
                $this->putSQL($field, "'" . $value . "'");
            }
        } elseif (is_integer($value)) {
            if ($value == 0) {
                return false;
            } else {
                $this->putSQL($field, $value);
            }
        } else {
            $this->putSQL($field, "'" . $value . "'");
        }
        return true;
    }

    /**
     * @param $field
     * @param $value
     * @return bool
     */
    private function nullable($field, $value)
    {
        if ($value == 0) {
            $value = 'null';
        }
        $this->putSQL($field, $value);
        return true;
    }

    /**
     * @param string $field
     * @param string $val
     * @return bool
     */
    private function integer(string $field, string $val)
    {
        $this->putSQL($field, $val);
        return true;
    }

    /**
     * @param string $field
     * @param string $val
     * @return bool
     */
    private function boolean(string $field, string $val)
    {
        switch ($val) {
            case "OUI":
            case "OK":
                $v = "true";
                break;
            case "":
            case "NON":
            case "KO":
                $v = "false";
                break;
            default:
                echo "erreur inconnue xxx '$val' xxx\n";
                exit;
        }
        $this->putSQL($field, $v);
        return true;
    }

    /**
     * @param $field
     * @param $val
     * @return bool
     */
    private function convertTemps($field, $val)
    {
        $val = trim($val);

        if ($val == "" || $val == '0' || $val == '0/0/0')
            $val="00:00:00";

        if (!($res = DateTime::createFromFormat('G i s', $val)) &&
            !($res = DateTime::createFromFormat('H i s', $val)) &&
            !($res = DateTime::createFromFormat('H\/i\/s', $val)) &&
            !($res = DateTime::createFromFormat('G\/i\/s', $val)) &&
            !($res = DateTime::createFromFormat('G:i:s', $val)) &&
            !($res = DateTime::createFromFormat('H:i:s', $val)) &&
            !($res = DateTime::createFromFormat('H\ \h\ i\ \m\n\ s\ \s', $val)) &&
            !($res = DateTime::createFromFormat('G\ \h\ i\ \m\n\ s\ \s', $val))) {
            var_dump(DateTime::getLastErrors());
            echo "Pas de format pour : $val\n";
            return true;
        } else {
            $fmt = $res->format("H:i:s");
            //echo "$field : $val -> $fmt\n";
            $this->putSQL($field, "'" . $fmt . "'");

            if ($field == 'temps') {
                $t = explode(":",$fmt);
                $dt = ($t[0] + $t[1]/60 + $t[2]/3600);
                $vitesse = 10.0 / $dt;
                //echo "vitesse = $vitesse\n";
                $this->putSQL("vitesse", sprintf("'%02.2f Km/h'",$vitesse));
            }
        }
        return true;
    }

    /**
     * @param string $field
     * @param string $val
     * @return bool
     */
    private function myDate(string $field, $val)
    {
        $d = explode("-", $val);
        if (@checkdate($d[1], $d[2], $d[0]))
            $date = "'" . $val . "'";
        else
            $date = 'null';
        $this->putSQL($field, $date);
        return true;
    }

    /**
     * @param string $field
     * @param string $val
     * @return bool
     */
    private function create_password(string $field, string $val)
    {
        $this->putSQL($field, "'" . password_hash($val, PASSWORD_BCRYPT) . "'");
        return true;
    }

    /**
     * @param string $field
     * @param string $val
     * @return bool
     */
    private function getImage(string $field, string $val)
    {

        if ($val != 0) {
            $res = $this->baseSrc->query("select * from preprod_blog_images where Ref = $val");
            $d = $res->fetch_assoc();
            $txt = "'" . $d['ImageSrc'] . "'";
        } else {
            $txt = 'null';
        }
        $this->putSQL($field, $txt);
        return true;
    }

    /**
     * @param string $field
     * @param string $val
     * @return bool
     */
    private function set_roles(string $field, string $val)
    {

        $dest_roles = [];
        $dest_roles[] = 'ROLE_USER';
        $dest_roles[] = 'ROLE_ADMIN';

        $texte = serialize($dest_roles);
        $this->putSQL($field, "'" . $texte . "'");
        return true;
    }

    /**
     * @param string $field
     * @param string $val
     * @return bool
     */
    private function create_username(string $field, string $val)
    {
        $prenom = strtolower($this->data['PRENOM']);
        $prenom = str_replace(' ', '_', $prenom);
        $prenom = str_replace('-', '_', $prenom);

        $nom = strtolower($this->data['NOM']);
        $nom = str_replace(' ', '_', $nom);
        $nom = str_replace('-', '_', $nom);

        $this->putSQL($field, "'" . $prenom . '_' . $nom . "'");
        return true;
    }

    private function json(string $field, string $value)
    {

        if (($value == 'NON' || $value == '') && $field == 'liste_droits') {
            $value = "PN1:NON|PN2:NON|PN3:NON|PN4:NON|PMF1:NON|PINI:NON|ENF:NON|ADO:NON|PMT:NON|APN:NON|BAP:NON|CRT:NON|ADM:NON|ENC:NON|GON:NON|MAT:NON|PUB:NON|BUR:NON";
        }

        if ($value == '' && $field == 'diplomes') {
            $value = "TIV:NON|FTIV:NON|PSXX:NON|ANTEOR:NON|FED:NON";
        }

        if ($value == 'OK' && $field == 'admin_ok') {
            $value = "DOSS:OK|CERTIF:OK|NIVP:OK|NIVA:OK|SIUAPS:OK|ESIUAPS:OK|EGUC:OK|COTIS:OK|FACT:OK|PISC:OK|MAT:OK|FEDE:OK|AXA:OK|VALID:OK";
        }

        if (($value == 'NON' || $value == '') && $field == 'admin_ok') {
            $value = "DOSS:KO|CERTIF:KO|NIVP:KO|NIVA:KO|SIUAPS:KO|ESIUAPS:KO|EGUC:KO|COTIS:KO|FACT:KO|PISC:KO|MAT:KO|FEDE:KO|AXA:KO|VALID:KO";
        }

        $res_tab = explode('|', $value);

        $tabres = [];
        foreach ($res_tab as $k) {
            $b = explode(':', $k);
            $key = $b[0];
            if ($b[1] == "OUI" || $b[1] == 'OK')
                $tabres[] = $key;
        }
        $this->putSQL($field, "'" . json_encode($tabres) . "'");
        return true;
    }

    /**
     * @param string $tableSrc
     * @param string $tableDst
     * @param array $tabCorresp
     */
    private function transfertDatabase(string $tableSrc, string $tableDst, array $tabCorresp)
    {

        $res = $this->baseSrc->query("select * from $tableSrc");

        while ($this->data = $res->fetch_assoc()) {

            $this->id = $this->data['Ref'];
            echo $this->id . "\n";
            $this->sql = [];
            $row = true;

            foreach ($tabCorresp as $key => $val) {
                $dest_field = $key;
                $source_field = $tabCorresp[$key][0];
                $action = $tabCorresp[$key][1];
                if ($action != "") {
                    // Appel de la fonction
                    if ($source_field != "")
                        $field = $this->data[$source_field];
                    else
                        $field = '';
                    if (!$this->$action($dest_field, $field)) {
                        $row = false;
                        break;
                    }
                } else {
                    $string = "'" . $this->baseDst->escape_string(trim($this->data[$source_field])) . "'";
                    $this->putSQL($dest_field, $string );
                }
            }
            if (!$row) {
                continue;
            }
            $assigns = "";
            $sep = ' ';
            foreach ($this->sql as $k => $v) {
                $assigns .= "\n    $sep$k=$v";
                $sep = ', ';
            }
            $sqlfinal = "insert into $tableDst set$assigns";

            $this->myQuery($this->baseDst, $sqlfinal);

            if (count($this->sqlLast) > 0) {
                foreach ($this->sqlLast as $sq) {
                    $this->myQuery($this->baseDst, $sq);
                }
                //echo serialize($this->sqlLast) . "\n";
                $this->sqlLast = [];
            }
        }
    }

    /**
     *
     */
    private function emptyBase()
    {
        $this->myQuery($this->baseDst,'delete from role');
        $this->myQuery($this->baseDst,'delete from diplome');
        $this->myQuery($this->baseDst,'delete from adherent');
        $this->myQuery($this->baseDst,'delete from blog');
    }

    /**
     *
     */
    public function doConvert()
    {
        $this->emptyBase();

        $this->transfertDatabase('preprod_liste', 'adherent', $this->correspAdherents);
        $this->transfertDatabase('preprod_blog_text', 'blog', $this->correspBlogTextes);
        //$this->transfertDatabase('preprod_classement', 'resultat', $this->correspResultats);
    }
}
?><!DOCTYPE html><html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        <meta http-equiv="content-language" content="fr">
        <meta name="language" content="fr">
        <meta charset="utf-8">
    </head>
    <body>
        <pre>
<?php

$context = new ConvertDatabase();
$context->doConvert();

?>
        </pre>
    </body>
</html>