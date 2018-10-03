<?php

class ConvertDatabase
{
    /**
     * @var array
     * @uses set_roles,adminok,create_password,nullable,integer,boolean,guc_date,create_username
     */
    private $correspAdherents = [
        "id"                    => ["Ref"           , "integer"],
        "username"              => [""              , "create_username"],
        "nom"                   => ["NOM"           , ""],
        "prenom"                => ["PRENOM"        , ""],
        "mail"                  => ["MAIL"          , ""],
        "roles"                 => [""              , "set_roles"],
        //"liste_droits"          => ["DROITS"        , "json"],
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
        //"diplomes"              => ["DIPLOMES"      , "json"],
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
        "admin_ok"              => ["ADMINOK"       , "adminok"],
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
        "user_id"               => ["NOM"           , "makeUser"],
        "type"                  => ["TYPE"          , "makeType"],
        "date_obtention"        => ["DATEOBT"       , "myDate"],
        "date_recyclage"        => ["DATERECYCL"    , "myDate"],
        "numero"                => ["NUMERO"        , ""],
        "commentaire"           => ["COMMENTAIRE"   , ""]
    ];

    private $id = 0;
    private $sql = [];
    private $data = [];
    private $sqlLast = [];

    private $baseSrc;
    private $baseDst;

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

    private function myQuery(mysqli $m, $query)
    {
        //echo $query . "\n\n";
        if (!$m->query($query)) {
            echo "Erreur SQL : " . $m->error . "\n";
        }
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
     * @param string $value
     * @return bool
     */
    private function adminok(string $field, string $value)
    {
        $tabaok = [
            "PRE"       => [ 0 , "PREINSCR"],
            "DOSS"      => [ 1 , "DOSSIER"],
            "CERTIF"    => [ 2 , "CERTIF"],
            "NIVP"      => [ 3 , "NIVEAUSCA"],
            "NIVA"      => [ 4 , "NIVEAUAPN"],
            "SIUAPS"    => [ 5 , "SIUAPS"],
            "ESIUAPS"   => [ 6 , "ESIUAPS"],
            "GUC"       => [ 7 , "GUC"],
            "EGUC"      => [ 7 , "EGUC"],
            "COTIS"     => [ 8 , "COTIS"],
            "FACT"      => [ 9 , "FACTURE"],
            "PISC"      => [10 , "PISCINE"],
            "MAT"       => [11 , "MATERIEL"],
            "FEDE"      => [12 , "FEDE"],
            "AXA"       => [13 , "AXA"],
            "INSCRIT"   => [14 , "INSCRIT"],
            "VALID"     => [14 , "INSCRIT"]
        ];

        if (($value == 'NON' || $value == '') && $field == 'liste_droits') {
            $value = "PN1:NON|PN2:NON|PN3:NON|PN4:NON|PMF1:NON|PINI:NON|ENF:NON|ADO:NON|PMT:NON|APN:NON|BAP:NON|CRT:NON|ADM:NON|ENC:NON|GON:NON|MAT:NON|PUB:NON|BUR:NON";
        }

        if ($value == '' && $field == 'diplomes') {
            $value = "TIV:NON|FTIV:NON|PSXX:NON|ANTEOR:NON|FED:NON";
        }

        if ($value == 'OK' && $field == 'admin_ok') {
            $value = "INSCRIT:OK";
        }

        if ($value == 'NON' && $field == 'admin_ok') {
            $value = "PRE:OK";
        }

        if ($value == '' && $field == 'admin_ok') {
            $value = "PRE:KO";
        }

        $res_tab = explode('|', $value);

        $pre = false;
        $tabres = [];
        foreach ($res_tab as $k) {
            $b = explode(':', $k);
            $key = $b[0];
            if ($b[1] == "OUI" || $b[1] == 'OK') {
                $pre = true;
                $tabres[$tabaok[$key][0]] = $tabaok[$key][1];
            }

        }
        if ($field == 'admin_ok') {
            if ($pre) {
                $tabres[$tabaok['PRE'][0]] = $tabaok['PRE'][1];
            }
            ksort($tabres);
            $strres = '';
            $delim = '';
            foreach ($tabres as $v) {
                $strres .= "$delim$v";
                $delim = '|';
            }
        }
        $this->putSQL($field,  "'" . $strres . "'");
        return true;
    }

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
     * @param $field
     * @param $value
     * @return bool
     */
    private function makeUser($field, $value)
    {
        $np = explode(' ', $value);
        $nom = $np[0];
        $prenom = $np[1];

        $res = $this->baseSrc->query("select Ref from preprod_liste where NOM = '$nom' and PRENOM = '$prenom'");
        if ($res == false) {
            echo $this->baseSrc->error_listerror;
        }
        $d = $res->fetch_assoc();

        $id = $d['Ref'];

        if (is_numeric($id)) {
            $this->putSQL('user_id', "$id");
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $field
     * @param $value
     * @return bool
     */
    private function makeType($field, $value)
    {
        switch ($value) {
            case "T":    $dest = 'TIV';             break;
            case "FT":   $dest = 'Formateur TIV';   break;
            case "MF":   $dest = 'Médecin fédéral'; break;
            case "MA":   $dest = 'Médecin';         break;
            case "PA":   $dest = 'PSE1/ANTEOR';     break;
        }
        $this->putSQL($field, "'$dest'");
        return true;
    }

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
     * @param string $field
     * @param string $val
     * @return bool
     */
    private function set_roles(string $field, string $val)
    {

        $dest_roles = [];
        $fEnc = false;

        $dest_roles[] = 'ROLE_USER';

        if ($this->data['DROITS'] != 'NON' && $this->data['DROITS'] != '') {

            $droits = explode('|', $this->data['DROITS']);

            foreach ($droits as $k) {
                $role = explode(':', $k);
                if ($role[1] == 'OUI') {
                    switch ($role[0]) {
                        case "PN1":    $dest_roles[] = 'ROLE_PN1';      $fEnc = true;       break;
                        case "PN2":    $dest_roles[] = 'ROLE_PN2';      $fEnc = true;       break;
                        case "PN3":    $dest_roles[] = 'ROLE_PN3';      $fEnc = true;       break;
                        case "PN4":    $dest_roles[] = 'ROLE_PN4';      $fEnc = true;       break;
                        case "PMF1":   $dest_roles[] = 'ROLE_PMF1';     $fEnc = true;       break;
                        case "PINI":   $dest_roles[] = 'ROLE_PINI';     $fEnc = true;       break;
                        case "ENF":    $dest_roles[] = 'ROLE_ENFANT';   $fEnc = true;       break;
                        case "ADO":    $dest_roles[] = 'ROLE_ADO';      $fEnc = true;       break;
                        case "PMT":    $dest_roles[] = 'ROLE_PMT';      $fEnc = true;       break;
                        case "APN":    $dest_roles[] = 'ROLE_APNEE';    $fEnc = true;       break;
                        case "BAP":    $dest_roles[] = 'ROLE_BAPTEME';  $fEnc = true;       break;
                        case "CRT":    $dest_roles[] = 'ROLE_CRT';                          break;
                        case "ADM":    $dest_roles[] = 'ROLE_ADMIN';                        break;
                        case "GON":    $dest_roles[] = 'ROLE_GON';                          break;
                        case "MAT":    $dest_roles[] = 'ROLE_MAT';                          break;
                        case "PUB":    $dest_roles[] = 'ROLE_PUB';                          break;
                        case "BUR":    $dest_roles[] = 'ROLE_BUREAU';                       break;
                    }
                }
            }
            if ($fEnc) {
                $dest_roles[] = 'ROLE_ENCADRANT';
            }
        }
        foreach ($dest_roles as $role) {
            $this->sqlLast[] = "insert into role set adherent_id = $this->id, role = '$role'";
        }
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

    private function emptyBase()
    {
        $this->myQuery($this->baseDst,'delete from role');
        $this->myQuery($this->baseDst,'delete from adherent');
        $this->myQuery($this->baseDst,'delete from diplome');
        $this->myQuery($this->baseDst,'delete from blog');
    }

    public function doConvert()
    {
        $this->emptyBase();

        $this->transfertDatabase('preprod_liste', 'adherent', $this->correspAdherents);
        $this->transfertDatabase('preprod_blog_text', 'blog', $this->correspBlogTextes);
        $this->transfertDatabase('preprod_diplomes', 'diplome', $this->correspDiplomes);
    }
}
?><!DOCTYPE html><html>
    <head>
        <meta http-equiv="content-language" content="fr">
        <meta name="language" content="fr">
        <meta charset="UTF-8">
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