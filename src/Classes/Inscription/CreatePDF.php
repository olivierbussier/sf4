<?php

namespace App\Classes\Inscription;

use App\Classes\Config\Config;
use App\Classes\Helpers\DateHelper;
use App\Classes\PDF\GucPDF;
use App\Entity\User;
use App\Entity\Diplome;
use DateTime;

class CreatePDF
{
    /**
     * Convertion de UTF8 vers CP1252 utilisé dans PDF
     * @param string
     * @return string
     */
    private function conv2pdf(string $chaine): string
    {
        return iconv("UTF-8", "CP1252", $chaine);
    }

    /**
     * @param string $user
     * @param string $FileNamePDF
     * @param string $FileNameJPG
     * @param float $TotalGUC
     * @param float $TotalAXA
     * @return bool
     */
    public function createPDF(
        User $user,
        string $FileNamePDF,
        string $FileNameJPG,
        float $TotalGUC,
        float $TotalAXA
    ): bool {

        $pdf = new GucPDF('P', 'mm', "A4");
        $pdf->setTemplate("fiche_insc");

        $fPhoto = true;

        if ($FileNameJPG == "" || !file_exists($FileNameJPG)) {
            $FileNameJPG = "../images/photo-blank.jpg";
            $fPhoto = false;
        }

        // Récapitulatif des docs à apporter

        $liste_diplomes = '';

        /** @var User $user */
        /** @var Diplome $diplome */

        foreach ($user->getDiplomes() as $diplome) {
            $liste_diplomes .= $diplome->getType();
        }

        $msg = array();
        if ($user->getNiveauSca() != "Enfant" && $user->getNiveauSca() != "Débutant" && $liste_diplomes != '') {
            $msg[] = " - une photocopie de vos diplômes (" . $liste_diplomes . ")";
        }
        if ($fPhoto == false) {
            $msg[] = " - Une photo d'identité (avec votre nom et prénom au dos)";
        }
        $msg[] = " - une photocopie de votre certificat médical si vous ne l'avez pas téléchargé";
        if ($user->getLicence() == "Autre Club") {
            $msg[] = " - une photocopie de votre licence " . Config::p_annee . "-" . (Config::p_annee + 1) .
                     " si vous ne l'avez pas téléchargée";
        }
        //if (Form::get('CARTESIUAPS') == "NON") {
        //    $msg[] = " - une photocopie de votre carte SIUAPS " . Config::p_annee . "-" . (Config::p_annee + 1);
        //}
        $msg[] = " - un chèque de " . $TotalGUC . "€ à l'ordre du GUC Plongée";
        if ($TotalAXA > 0) {
            $msg[] = " - un chèque de " . $TotalAXA . "€ à l'ordre de AXA Assurance";
        }
        if ($user->getPretMateriel() == "OUI") {
            $msg[] = " - un chèque de caution de " . Config::CAUTION_MATOS .
                "€ à l'ordre du GUC Plongée pour le prêt de matériel";
        }
        $msg[] = " - un chèque de caution de " . Config::BADGE_PISCINE .
            "€ à l'ordre du GUC Plongée pour le badge d'accès piscine";
        $msg[] = " Les photocopies des diplômes sont facultatives si le club les a déjà";
        $i = 1;
        foreach ($msg as $key => $value) {
            $label = "@doc" . $i++;
            $pdf->PDFSetLabel($label, $this->conv2pdf($value));
        }

        if ($user->getReducFam() == '') {
            $pdf->PDFSetLabel(
                "@doc10",
                $this->conv2pdf("Votre indentifiant réduction famille est : " . $user->getReducFamilleID())
            );
        } else {
            $pdf->PDFSetLabel(
                "@doc10",
                $this->conv2pdf("Bénéficiant de la réduction famille, ".
                                       "Votre indentifiant réduction famille n'est pas utilisable")
            );
        }
        // Diplômes

        foreach ($user->getDiplomes() as $diplome) {
            $liste_diplomes .= $diplome->getType();
        }

        $msg = array();
        /** @var Diplome $diplome */
        foreach ($user->getDiplomes() as $diplome) {
            $msg[] = $diplome->getType();
        }

        $i = 1;
        foreach ($msg as $key => $value) {
            $label = "@dipl" . $i++;
            $pdf->PDFSetLabel($label, $this->conv2pdf($value));
        }

        $pdf->PDFSetLabel("@flag1", $this->conv2pdf($user->getActivite()));
        $pdf->PDFSetLabel("@flag2", 'GUC:' . $TotalGUC);
        $pdf->PDFSetLabel("@flag3", 'AXA:' . $TotalAXA);

        $pdf->PDFSetLabel("@texaninscr", "Inscription " . Config::p_annee . "-" . (Config::p_annee + 1));
        $pdf->PDFSetLabel("@photo", $FileNameJPG);
        $pdf->PDFSetLabel("@textnomadh", $this->conv2pdf($user->getNom() . " " . $user->getPrenom()));
        $pdf->PDFSetLabel("@textnumadh", $user->getId());

        $pdf->PDFSetLabel("@adhname", $this->conv2pdf($user->getGenre() . " " . $user->getNom() . " " . $user->getPrenom()));
        $pdf->PDFSetLabel("@addr", $this->conv2pdf($user->getAdresse1() . "\n" . $user->getAdresse2()));
        $pdf->PDFSetLabel("@codep", $user->getCodePostal());
        $pdf->PDFSetLabel("@ville", $this->conv2pdf($user->getVille()));
        $pdf->PDFSetLabel("@profess", $this->conv2pdf($user->getProfession()));
        $pdf->PDFSetLabel("@datnaiss", $user->getDateNaissance());

        $pdf->PDFSetLabel("@telfix", $user->getTelFix());
        $pdf->PDFSetLabel("@telpor", $user->getTelPort());
        $pdf->PDFSetLabel("@mail", $user->getMail());
        $pdf->PDFSetLabel("@etudiant", $user->getFEtudiant() ? "X" : "");

        $pdf->PDFSetLabel("@nivscaph", $this->conv2pdf($user->getNiveauSca()));
        $pdf->PDFSetLabel("@nivapnee", $this->conv2pdf($user->getNiveauApn()));
        $pdf->PDFSetLabel("@activite", $this->conv2pdf($user->getActivite()));

        if ($user->getFBenevole()) {
            $pdf->PDFSetLabel("@choixbene", "X");
        } else {
            $pdf->PDFSetLabel("@choixbene", "");
        }
        if ($user->getFEncadrant()) {
            $pdf->PDFSetLabel("@choixenca", "X");
        } else {
            $pdf->PDFSetLabel("@choixenca", "");
        }

        // CAESUG / FACTURE
        if ($user->getFacture() == 'CAESUG') {
            $pdf->PDFSetLabel("@choixcaesug", "X");
        } else {
            $pdf->PDFSetLabel("@choixcaesug", "");
        }
        if ($user->getFacture() == 'OUI') {
            $pdf->PDFSetLabel("@choixfac", "X");
        } else {
            $pdf->PDFSetLabel("@choixfac", "");
        }

        $xx = $user->getFCarteGUC() ? "X" : "";
        $pdf->PDFSetLabel("@choixguc", $xx);
        $xx = $user->getFCarteSIUAPS() ? "X" : "";
        $pdf->PDFSetLabel("@choixsiuaps", $xx);
        $xx = $user->getPretMateriel() ? "X" : "";
        $pdf->PDFSetLabel("@choixmat", $xx);
        $pdf->PDFSetLabel("@intolasp", $user->getFAllergAspirine() ? "X" : "");

        // TODO insérer le'identifiant reduction famille dans le pdf

        $pdf->PDFSetLabel("@choixfam", ($user->getReducFam() != '') ? "X" : "");
        $pdf->PDFSetLabel("@choixcotguc", $this->conv2pdf($user->getCotisation()));
        $pdf->PDFSetLabel("@choixffessm", $this->conv2pdf($user->getLicence()));
        $pdf->PDFSetLabel("@choixaxa", $this->conv2pdf($user->getAssurance()));
        $pdf->PDFSetLabel("@datecertif", $user->getDateCertif()->format('d/m/Y'));

        $pdf->PDFSetLabel("@nomacc", $this->conv2pdf($user->getAccidentNom()));
        $pdf->PDFSetLabel("@prenomacc", $this->conv2pdf($user->getAccidentPrenom()));
        $pdf->PDFSetLabel("@telfixacc", $user->getAccidentTelFix());
        $pdf->PDFSetLabel("@telporacc", $user->getAccidentTelPort());

        $pdf->PDFSetLabel("@axalien", Config::P_LAXA);

        $pdf->PDFSetLabel("@datejour", date("d/m/Y"));

        $age = DateHelper::ageAujourdhui($user->getDateNaissance()->format('Y-m-d'));
        if ($age < 18) {
            $pdf->PDFSetLabel("@tutorname", $this->conv2pdf($user->getMineurNom() . " " . $user->getMineurPrenom()));
            $pdf->PDFSetLabel("@lienparen", $this->conv2pdf($user->getMineurQualite()));
        } else {
            $pdf->PDFSetLabel("@tutorname", "Non Applicable");
            $pdf->PDFSetLabel("@lienparen", "Non Applicable");
        }
        $pdf->PDFSetLabel("@infobas", $this->conv2pdf(Config::P_BAS));

        $pdf->GenererPDF($FileNamePDF);

        return true;
    }

    /**
     * @param $Date
     * @param $RefUsr
     * @param $tab
     * @return int
     */
    public function factureExists($RefUsr)
    {
        $db = Globals::getDb();

        $res = $db->query("select * from @#@liste where Ref = '$RefUsr'");
        $d = $db->nextrow($res);
        $NOM     = $d['NOM'];
        $PRENOM  = $d['PRENOM'];
        $REFFACT = $d['REFFACT'];
        return file_exists(
            FileHelpers::corrigerPath(
                "../factures/" . $NOM . "-" . $PRENOM . "-" . $RefUsr . "-" . $REFFACT . ".pdf"
            )
        );
    }

    public function createFacturePDF($Date, $RefUsr, $tab)
    {

        $db = Globals::getDb();

        $pdf = new GucPDF('P', 'mm', "A4");

        // En entrée, $tab pointe vers une lite d'items a afficher dans la facture
        // sous la forme :
        //  - tab[x]['libelle']   == Designation
        //  - tab[x]['montantht'] == Montant H.T
        //  - tab[x]['taux']      == Taux de taxe

        $pdf->setTemplate("facture");

        $res = $db->query("select * from @#@liste where Ref = '$RefUsr'");

        // Récapitulatif des docs à apporter

        $d = $db->nextrow($res);

        $NOM = $d['NOM'];
        $PRENOM = $d['PRENOM'];

        $pdf->PDFSetLabel("@destinat", $this->conv2PDF($NOM . " " . $PRENOM));

        $t[] = $d['ADD1'];
        if ($d['ADD2'] != '') {
            $t[] = $d['ADD2'];
        }
        $t[] = $d['VILLE'];
        $t[] = $d['CODEP'];
        $i = 1;
        foreach ($t as $key => $value) {
            $pdf->PDFSetLabel("@ad" . $i++, $this->conv2PDF($value));
        }

        for ($i = 1; $i <= 10; $i++) {
            $pdf->PDFSetLabel("@i" . $i, "");
            $pdf->PDFSetLabel("@h" . $i, "");
            $pdf->PDFSetLabel("@v" . $i, "");
            $pdf->PDFSetLabel("@t" . $i, "");
        }

        $i = 1;

        $TotalHT = 0;
        $TotalTTC = 0;
        $TotalTax = 0;

        $ligne = [];
        // Construction des lignes de facture

        // Prix Licence
        // Reduction famille
        // Prise en charge CAESUG
        //
        $item = $tab['licence'];
        $ligne[] = [ 'text' => 'Cotisation : ' . $item['typeCotis'], 'prix' => $item['prixCotis']];
        $ligne[] = [ 'text' => 'Licence FFESSM : ' . $item['typeLicence'], 'prix' => $item['prixLicence']];
        if ($item['prixReduc'] > 0) {
            $ligne[] = [
                'text' => ' - Réduction Famille',
                'prix' => $item['prixReduc']
            ];
        }
        if ($item['prixCaesug'] > 0) {
            $ligne[] = [
                'text' => ' - Prise en charge CAESUG',
                'prix' => $item['prixCaesug']
            ];
        }
        if ($item['prixReduc'] > 0 || $item['prixCaesug'] > 0) {
            $TotalHT = ($item['prixCotis'] + $item['prixLicence'] - $item['prixReduc']) - $item['prixCaesug'];
            $ligne[] = [
                'text' => ' - Reste à charge de l\'adhérent :',
                'prix' => $TotalHT
            ];
        } else {
            $TotalHT = $item['prixCotis'] + $item['prixLicence'];
        }
        $TotalTTC += $TotalHT * (1 + Config::TAXE);
        $TotalTax += ($TotalHT * Config::TAXE);

        foreach ($ligne as $value) {
            $libelle = $value['text'];
            $prix    = $value['prix'];

            $pdf->PDFSetLabel(
                "@i" . $i,
                $this->conv2pdf($libelle)
            );
            $pdf->PDFSetLabel(
                "@h" . $i,
                $this->conv2pdf(
                    number_format(
                        (float)$prix,
                        2,
                        '.',
                        ' '
                    ) . " €"
                )
            );
            $pdf->PDFSetLabel("@v" . $i, (Config::TAXE * 100) . "%");
            $pdf->PDFSetLabel(
                "@t" . $i,
                $this->conv2pdf(
                    number_format(
                        (float)$prix * (1 + Config::TAXE),
                        2,
                        '.',
                        ' '
                    ) . " €"
                )
            );
            $i++;
        }
        $pdf->PDFSetLabel(
            "@totht",
            $this->conv2pdf(
                number_format(
                    (float)$TotalHT,
                    2,
                    '.',
                    ' '
                ) . " €"
            )
        );
        $pdf->PDFSetLabel(
            "@totttc",
            $this->conv2pdf(
                number_format(
                    (float)$TotalTTC,
                    2,
                    '.',
                    ' '
                ) . " €"
            )
        );
        $pdf->PDFSetLabel(
            "@tottax",
            $this->conv2pdf(
                number_format(
                    (float)$TotalTax,
                    2,
                    '.',
                    ' '
                ) . " €"
            )
        );

        // Calcul référence de facture
        if ($d['REFFACT'] == 0) {
            $db->query("insert into @#@factures set " .
                "DATEGEN   ='$Date'," .
                "REFUSR    ='$RefUsr'," .
                "MONTANTHT ='$TotalHT'," .
                "MONTANTTTC='$TotalTTC'");
            $Ref = $db->last_insert_id();
        } else {
            $Ref = $d['REFFACT'];
            $db->query("update @#@factures set " .
                "DATEGEN   ='$Date'," .
                "MONTANTHT ='$TotalHT'," .
                "MONTANTTTC='$TotalTTC' where Ref = '" . $Ref . "'");
        }
        $reffact = date('Y') . '-' . sprintf("%05d", $Ref);
        $pdf->PDFSetLabel('@reffact', $reffact);
        $pdf->PDFSetLabel('@date', date('d/m/Y'));
        $db->query("update @#@liste set " .
            "REFFACT   ='" . $Ref . "' where Ref = '" . $RefUsr . "'");
        // Nouvelle facture -> RAZ de la date d'envoi
        $db->query("update @#@factures set " .
            "DATESENT ='0000-00-00' where Ref = '" . $Ref . "'");
        $pdf->genererPDF(
            FileHelpers::corrigerPath(
                "../factures/" . $NOM . "-" . $PRENOM . "-" . $RefUsr . "-" . $Ref . ".pdf"
            )
        );
        return $Ref;
    }

    /**
     * @param $pathpdf
     * @param $pathident
     * @param $Ref
     * @return bool
     */
    public function genPDFFromDB($pathpdf, $pathident, $Ref): bool
    {
        $db = Globals::getDb();

        $sql = "select * from @#@liste where Ref='$Ref'";
        $res = $db->query($sql);

        if ($db->numrows($res) != 1) {
            echo "erreur 7856\n";
            return false;
        }

        $d = $db->nextrow($res);
        Form::initialise($d);

        $l = new Calculate();

        $cot = $l->calcCotis(Form::getArray());
        $ass = $l->calcAxa(Form::get('ASSURANCE'));

        $date = new DateTime(GucDate::dgm(Form::get('DATENAISS')));
        $now = new DateTime();
        $interval = $now->diff($date);
        $age = $interval->y;


        $NOM = $d['NOM'];
        $PRENOM = $d['PRENOM'];

        return $this->createPDF(
            $Ref,
            $NOM,
            $PRENOM,
            FileHelpers::corrigerPath($pathpdf . "/" . $NOM . "-" . $PRENOM . "-" . $Ref . ".pdf"),
            FileHelpers::corrigerPath($pathident . "/" . $NOM . "-" . $PRENOM . "-" . $Ref . "-th.jpg"),
            $age,
            $cot['prixCotis'] - $cot['prixCaesug'],
            $ass['prixAxa'],
            $cot['fBene'],
            $cot['fEnc']
        );
    }
}
