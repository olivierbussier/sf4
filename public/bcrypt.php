<?php

$correspAdherents = [
    "id"                     => ["Ref"           ,"integer"],
    "username"               => [""              ,"create_username"],
    "nom"                    => ["NOM"           ,""],
    "prenom"                 => ["PRENOM"        ,""],
    "mail"                   => ["MAIL"          ,""],
    "roles"                  => [""              ,"set_roles"],
    "liste_droits"           => ["DROITS"        ,"json"],
    "code_secret"            => ["PASSWD"        ,""],
    "password"               => ["PASSWD"        ,"create_password"],
    "genre"                  => ["GENRE"         ,""],
    "adresse1"               => ["ADD1"          ,""],
    "adresse2"               => ["ADD2"          ,""],
    "code_postal"            => ["CODEP"         ,""],
    "ville"                  => ["VILLE"         ,""],
    "profession"             => ["PROFESSION"    ,""],
    "date_naissance"         => ["DATENAISS"     ,"guc_date"],
    "lieu_naissance"         => ["LIEUNAISS"     ,""],
    "departement_naissance"  => ["DEPTNAISS"     ,""],
    "tel_fix"                => ["TELFIX"        ,""],
    "tel_port"               => ["TELPORT"       ,""],
    "f_etudiant"             => ["ETUDIANT"      ,"boolean"],
    "niveau_sca"             => ["NIVEAU"        ,""],
    "niveau_apn"             => ["APNEE"         ,""],
    "diplomes"               => ["DIPLOMES"      ,"json"],
    "f_apnee_sca"            => ["APNEESCA"      ,"boolean"],
    "activite"               => ["ACTIVITE"      ,""],
    "f_benevole"             => ["BENEVOLE"      ,"boolean"],
    "f_encadrant"            => ["ENCADRANT"     ,"boolean"],
    "accident_nom"           => ["ACCNOM"        ,""],
    "accident_prenom"        => ["ACCPRENOM"     ,""],
    "accident_tel_fix"       => ["ACCTELFIX"     ,""],
    "accident_tel_port"      => ["ACCTELPORT"    ,""],
    "date_certif"            => ["DATECERTIF"    ,"guc_date"],
    "f_allerg_aspirine"      => ["ALERGASP"      ,"boolean"],
    "licence"                => ["LICENCE"       ,""],
    "cotisation"             => ["COTISATION"    ,""],
    "f_carte_guc"            => ["CARTEGUC"      ,"boolean"],
    "f_carte_siuaps"         => ["CARTESIUAPS"   ,"boolean"],
    "f_mail_guc"             => ["MAILGUC"       ,"boolean"],
    "f_trombi"               => ["FTROMBI"       ,"boolean"],
    "envoi_guc"              => ["ENVOIGUC"      ,""],
    "envoi_siuaps"           => ["ENVOISIUAPS"   ,""],
    "facture"                => ["FACTURE"       ,""],
    "ref_facture"            => ["REFFACT"       ,""],
    "assurance"              => ["ASSURANCE"     ,""],
    "pret_materiel"          => ["PRETMAT"       ,"boolean"],
    "pret_materiel_old"      => ["PRETMATOLD"    ,"boolean"],
    "mineur_nom"             => ["MINNOM"        ,""],
    "mineur_prenom"          => ["MINPRENOM"     ,""],
    "mineur_qualite"         => ["MINQUAL"       ,""],
    "modif_user"             => ["MODIFUSER"     ,""],
    "date_modif_user"        => ["DATEMODIFUSER" ,"guc_date"],
    "date_prem_inscr"        => ["DATEPREMINSCR" ,"guc_date"],
    "admin_ok"               => ["ADMINOK"       ,"json"],
    "comments"               => ["COMMENTS"      ,""],
    "reduc_famille_id"       => ["REDUCFAMID"    ,""],
    "reduc_fam"              => ["REDUCFAM"      ,""]
];

$correspBlogTextes = [
    "id"                     => ["Ref"           ,"integer"],
    "ref_image_id"           => ["RefImage"      ,"nullable"],
    "date"                   => ["Date"          ,"guc_date"],
    "title"                  => ["Title"         ,""],
    "texte"                  => ["Texte"         ,""],
    "ordre"                  => ["Ordre"         ,"integer"],
    "link"                   => ["Link"          ,""],
    "position_image"         => ["PositionImage" ,""]
];

$correspBlogImages = [
    "id"                     => ["Ref"           ,"integer"],
    "image_src"              => ["ImageSrc"      ,""],
];

$sql = [];
$data = [];

/**
 * @param $field
 * @param $value
 */
function putSQL($field, $value)
{   global $sql;

    $sql[$field] = $value;
}

function nullable($field, $value)
{
    if ($value == 0) {
        $value ='null';
    }
    putSQL($field, $value);
}

/**
 * @param string $field
 * @param string $value
 */
function json(string $field, string $value)
{

    if (($value == 'NON' || $value == '') && $field == 'liste_droits') {
        $value = "PN1:NON|PN2:NON|PN3:NON|PN4:NON|PMF1:NON|PINI:NON|ENF:NON|ADO:NON|PMT:NON|APN:NON|BAP:NON|CRT:NON|ADM:NON|ENC:NON|GON:NON|MAT:NON|PUB:NON|BUR:NON";
    }

    if ($value == '' && $field == 'diplomes') {
        $value = "PN1:NON|PN2:NON|PN3:NON|PN4:NON|PMF1:NON|PINI:NON|ENF:NON|ADO:NON|PMT:NON|APN:NON|BAP:NON|CRT:NON|ADM:NON|ENC:NON|GON:NON|MAT:NON|PUB:NON|BUR:NON";
    }

    if ($value == 'OK' && $field == 'admin_ok') {
        $value = "DOSS:OK|CERTIF:OK|NIVP:OK|NIVA:OK|SIUAPS:OK|ESIUAPS:OK|EGUC:OK|COTIS:OK|FACT:OK|PISC:OK|MAT:OK|FEDE:OK|AXA:OK|VALID:OK";
    }

    if (($value == 'NON' || $value == '') && $field == 'admin_ok') {
        $value = "DOSS:KO|CERTIF:KO|NIVP:KO|NIVA:KO|SIUAPS:KO|ESIUAPS:KO|EGUC:KO|COTIS:KO|FACT:KO|PISC:KO|MAT:KO|FEDE:KO|AXA:KO|VALID:KO";
    }

    $res_tab = explode('|',$value);

    $tabres = [];
    foreach($res_tab as $k) {
        $b = explode(':',$k);
        $key = $b[0];
        if ($b[1] == "OUI" || $b[1] == 'OK')
			$tabres[$key] = true;
		else
			$tabres[$key] = false;
    }
    putSQL($field, "'".json_encode($tabres)."'");
}

function integer(string $field, string $val)
{
    putSQL($field, $val);
}

/**
 * @param string $field
 * @param string $val
 */
function boolean(string $field, string $val)
{
    switch ($val) {
        case "OUI":
        case "OK":
            $v = "true"; break;
        case "":
        case "NON":
        case "KO":
            $v = "false"; break;
        default:
            echo "erreur inconnue xxx '$val' xxx\n";
            exit;
    }
    putSQL($field,$v);
}

/**
 * @param string $field
 * @param string $val
 */
function guc_date(string $field, string $val)
{
    putSQL($field,"'".$val."'");
}

/**
 * @param string $field
 * @param string $val
 */
function create_password(string $field, string $val)
{
    putSQL($field,"'".password_hash($val, PASSWORD_BCRYPT)."'");
}

function set_roles(string $field, string $val)
{ global $data;

    $dest_roles = [];
    $fEnc = false;

    $dest_roles[] = 'ROLE_USER';

    if ($data['DROITS'] != 'NON' && $data['DROITS'] != '') {

        $droits = explode('|',$data['DROITS']);

        foreach($droits as $k) {
            $role = explode(':', $k);
            if ($role[1] == 'OUI') {
                switch ($role[0]) {
                    case "PN1":  $dest_roles[] = 'ROLE_PN1';    $fEnc = true;   break;
                    case "PN2":  $dest_roles[] = 'ROLE_PN2';    $fEnc = true;   break;
                    case "PN3":  $dest_roles[] = 'ROLE_PN3';    $fEnc = true;   break;
                    case "PN4":  $dest_roles[] = 'ROLE_PN4';    $fEnc = true;   break;
                    case "PMF1": $dest_roles[] = 'ROLE_PMF1';   $fEnc = true;   break;
                    case "PINI": $dest_roles[] = 'ROLE_PINI';   $fEnc = true;   break;
                    case "ENF":  $dest_roles[] = 'ROLE_ENFANT'; $fEnc = true;   break;
                    case "ADO":  $dest_roles[] = 'ROLE_ADO';    $fEnc = true;   break;
                    case "PMT":  $dest_roles[] = 'ROLE_PMT';    $fEnc = true;   break;
                    case "APN":  $dest_roles[] = 'ROLE_APNEE';  $fEnc = true;   break;
                    case "BAP":  $dest_roles[] = 'ROLE_BAPTEME';$fEnc = true;   break;
                    case "CRT":  $dest_roles[] = 'ROLE_CRT';                    break;
                    case "ADM":  $dest_roles[] = 'ROLE_ADMIN';                  break;
                    case "GON":  $dest_roles[] = 'ROLE_GON';                    break;
                    case "MAT":  $dest_roles[] = 'ROLE_MAT';                    break;
                    case "PUB":  $dest_roles[] = 'ROLE_PUB';                    break;
                    case "BUR":  $dest_roles[] = 'ROLE_BUREAU';                 break;
                }
            }
        }
        if ($fEnc) {
            $dest_roles[] = 'ROLE_ENCADRANT';
        }
    }
    putSQL($field, "'".json_encode($dest_roles)."'");
}

function transfertDatabase(mysqli $baseSrc, mysqli $baseDst, string $tableSrc, string $tableDst, array $tabCorresp)
{ global $sql;

    $sql = [];

    $res = $baseSrc->query("select * from $tableSrc");

    while($data = $res->fetch_assoc()) {

        $id = $data['Ref'];
        echo $id."\n";

        foreach ($tabCorresp as $key => $val) {
            $dest_field   = $key;
            $source_field = $tabCorresp[$key][0];
            $action       = $tabCorresp[$key][1];
            if ($action != "") {
                // Apple de la fonction
                if ($source_field != "")
                    $field = $data[$source_field];
                else
                    $field = '';
                $action($dest_field,$field);
            } else {
                putSQL($dest_field, "'".$baseDst->escape_string($data[$source_field])."'");
            }
        }
        $assigns = "";
        $sep = ' ';
        foreach ($sql as $k => $v) {
            $assigns .= "\n    $sep$k=$v";
            $sep = ', ';
        }
        $sqlfinal = "insert into $tableDst set$assigns";
        echo $sqlfinal."\n\n";
        if (!$baseDst->query($sqlfinal)) {
            echo $baseDst->error;
            exit;
        }
    }
}

function myQuery(mysqli $m, $query)
{
    if (!$m->query($query)) {
        echo $m->error;
    }
}

/**
 * @param string $field
 * @param string $val
 */
function create_username(string $field, string $val)
{ global $data;

    $prenom = strtolower($data['PRENOM']);
    $prenom = str_replace(' ','_',$prenom);
    $prenom = str_replace('-','_',$prenom);

    $nom    = strtolower($data['NOM']);
    $nom    = str_replace(' ','_',$nom);
    $nom    = str_replace('-','_',$nom);

    putSQL($field,"'".$prenom.'_'.$nom."'");
}

$source = new mysqli('localhost', 'root', '', 'adherents');
$dest   = new mysqli('localhost', 'root', '', 'sf4');


echo "<pre>";

myQuery($dest,'delete from blog');
myQuery($dest, 'delete from blog_images');

//transfertDatabase($source, $dest, 'preprod_liste', 'adherent', $correspAdherents);
transfertDatabase($source, $dest, 'preprod_blog_images', 'blog_images', $correspBlogImages);
transfertDatabase($source, $dest, 'preprod_blog_text', 'blog', $correspBlogTextes);




















