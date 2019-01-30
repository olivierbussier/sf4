<?php

namespace App\Classes\PDF;

class GucPDF extends Fpdf
{
    private $tablabel = [];
    private $bx = [];

    /**
     * @param $w
     * @param $txt
     * @return int
     */
    public function height($w, $txt)
    {
        /**
         * Calcule le nombre de lignes qu'occupe un MultiCell de largeur w
         */

        $cw =& $this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n") {
            $nb--;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            /**
             * Gestion du saut de ligne
             */
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }


    public function resolveLabel($label, $caserr = "")
    {

        if ($label[0] == '@') {
            if (!isset($this->tablabel[$label])) {
                echo "erreur label non d�clar� dans '$caserr' : '$label'\n";
                exit;
            } else {
                if ($this->tablabel[$label] === false) {
                    $text = $label;
                    //echo "erreur label non initialis� dans '$caserr' : '$label'\n";
                    //exit;
                } else {
                    $text = $this->tablabel[$label];
                }
            }
        } else {
            $text = $label;
        }
        return $text;
    }

    // *************************************************
    // Fonction � appeler pour positionner les variables
    // *************************************************
    public function PDFSetLabel($label, $texte)
    {
        if (!isset($this->tablabel[$label])) {
            echo "Erreur label inexistant : '$label'\n";
            exit;
        }
        $this->tablabel[$label] = $texte;
    }

    // *************************************************
    public function setTemplate($file)
    {
        include $file . ".php";
    }

    // *************************************************
    // Fonction � appeler pour g�n�rer le PDF
    // *************************************************
    public function genererPDF($filename)
    {
        $this->AddFont('Comic', '', 'comic.php');
        $this->AddFont('Comic', 'B', 'comicbd.php');
        $this->AddPage();
        $this->SetMargins(0, 0);
        $this->SetFont('Times', '', 12);
        $this->SetAutoPageBreak(false);

        foreach ($this->bx as $key => $v) {
            switch ($v['typ']) {
                //case "frame":
                case "colorbox":
                    $this->SetDrawColor($v['red'], $v['grn'], $v['blu']);
                    break;

                case "box":
                    $this->SetLineWidth(0.25);
                    $this->Rect($v['x'], $v['y'], $v['lx'], $v['ly'], 'D');
                    break;

                case "text":
                    $text = $this->resolveLabel($v['text'], "text");
                    $this->SetFont($v['face'], $v['style'], $v['size']);
                    $red = ($v['color'] & 0xff0000) >> 16;
                    $grn = ($v['color'] & 0x00ff00) >> 8;
                    $blu = ($v['color'] & 0x0000ff);
                    $this->SetTextColor($red, $grn, $blu);
                    $height = $this->height($v['lx'], $text);
                    $htext = $height * $this->FontSize;
                    $sy = ($v['ly'] - $htext) / 2 + $v['y'];
                    $this->SetXY($v['x'], $sy);
                    $this->MultiCell($v['lx'], $this->FontSize, $text, 0, $v['align']);
                    break;

                case "link":
                    $text = $this->resolveLabel($v['text'], "link");
                    $this->SetFont($v['face'], $v['style'], $v['size']);
                    $red = ($v['color'] & 0xff0000) >> 16;
                    $grn = ($v['color'] & 0x00ff00) >> 8;
                    $blu = ($v['color'] & 0x0000ff);
                    $this->SetTextColor($red, $grn, $blu);
                    $this->SetXY($v['x'], $v['y']);
                    $this->Cell($v['lx'], $this->FontSize, $text, 0, 0, $v['align'], false, $text);
                    break;

                case "image":
                    $text = $this->resolveLabel($v['label'], "image");
                    $this->Image($text, $v['x'], $v['y'], 0, $v['ly']);
                    break;

                default:
                    echo "erreur type token inconnu : '" . $v['typ'] . "'\n";
                    return false;
            }
        }
        $this->Output($filename, 'F');
        return true;
    }
    public function __construct(string $orientation = 'P', string $unit = 'mm', string $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
    }
}
