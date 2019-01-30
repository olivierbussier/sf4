<?php

namespace App\Classes\PDF;

class GenPDF extends GucPDF
{
    private $debug = false;

    private $phil = 0;

    /**
     * @var bool|resource $fil
     */
    private $fil = false;

    private $recurs = 0;

    private $tablabel;

    /**
     * @param $file
     * @return bool
     */
    private function openfile($file)
    {
        $this->phil = fopen($file, "rt");
        if ($this->phil == false)
            return false;
        $this->buffer = fread($this->phil, 1000000);
        if ($this->buffer == false)
            return false;
        return true;
    }

    /**
     *
     */
    private function cr()
    {
        if ($this->debug == false)
            return;
        echo "\n";
        for ($i = 0; $i < $this->recurs; $i++)
            echo "  ";

    }

    /**
     * @param $var
     * @param bool $type
     */
    private function e($var, $type = false)
    {
        if ($this->debug == false)
            return;
        if ($type == true) {
            var_dump($var);
        } else
            echo $var;
    }

    /**
     * @param $msg
     */
    private function Err($msg)
    {
        echo "\n".$this->buffer."\n--> $msg\n";
        exit(2);
    }

    /**
     * @return bool
     */
    private function SkipBlancs()
    {
        $trt = false;

        while ($trt == false) {
            // Skip des blancs

            $this->buffer = ltrim($this->buffer);

            if (strlen($this->buffer) == 0)
                return false; // Fin de fichier

            // Skip des commentaires

            if (strlen($this->buffer) >= 2 && $this->buffer[0] == '/' && $this->buffer[1] == '/') { // On finit la ligne
                $i = 2;
                $len = strlen($this->buffer);

                while ($i < $len && ($this->buffer[$i] != "\r" && $this->buffer[$i] != "\n"))
                    $i++;

                if ($i == $len) // fin du fichier
                    return false;

                $this->buffer = substr($this->buffer, $i);
                continue;
            }

            if (strlen($this->buffer) >= 2 && $this->buffer[0] == '/' && $this->buffer[1] == '*') { // On va jusque */
                $i = 2;
                $len = strlen($this->buffer);

                while (($this->buffer[$i] != '*' || $this->buffer[$i + 1] != '/') && $i < $len)
                    $i++;
                if ($i == $len) // fin du fichier
                    return false;
                $this->buffer = substr($this->buffer, $i + 2);
                continue;
            }
            $trt = true;
        }
        return true;
    }

    /**
     * @return bool|string
     */
    private function GetToken()
        /************************************************************/
    {
        // Début d'un token

        if ($this->SkipBlancs() == false)
            return false;

        $tok = strtok($this->buffer, " ;/(\r\n\t");
        if ($tok == false)
            return false;
        $this->buffer = substr($this->buffer, strlen($tok));
        return $tok;
    }

    /**
     * @return bool
     */
    private function GetLPar()
        /************************************************************/
    {
        if ($this->SkipBlancs() == false)
            return false;
        if ($this->buffer[0] != '(')
            return false;
        $this->buffer = substr($this->buffer, 1);
        $this->e("(");
        return true;
    }

    /**
     * @return bool
     */
    private function GetRPar()
        /************************************************************/
    {
        if ($this->SkipBlancs() == false)
            return false;
        if ($this->buffer[0] != ')')
            return false;
        $this->buffer = substr($this->buffer, 1);
        $this->e(")");
        return true;
    }

    /**
     * @param bool $progress
     * @return bool
     */
    private function GetLBrace($progress = true)
        /************************************************************/
    {
        if ($this->SkipBlancs() == false)
            return false;
        if ($this->buffer[0] != '{')
            return false;
        if ($progress == true)
            $this->buffer = substr($this->buffer, 1);
        $this->e("{");
        return true;
    }

    /**
     * @return bool
     */
    private function GetVirg()
        /************************************************************/
    {
        if ($this->SkipBlancs() == false)
            return false;
        if ($this->buffer[0] != ',')
            return false;
        $this->buffer = substr($this->buffer, 1);
        return true;
    }

    /**
     * @param $dep
     * @param $len
     * @return bool|float|int
     */
    private function GetNum($dep, $len)
        /************************************************************/
    {
        if ($this->SkipBlancs() == false)
            return false;
        $param = strtok($this->buffer, " ,/)\t\r\n");

        // Recherche %

        if ($param[strlen($param) - 1] == '%') {
            $p2 = substr($param, 0, strlen($param) - 1);
            $percent = floatval($p2);
            $value = (((float)$len * $percent) / (float)100.0) + (float)$dep; //e("/* $p2% */");
        } else
            $value = intval($param, 0) + $dep;
        $this->buffer = substr($this->buffer, strlen($param));
        return $value;
    }

    /**
     * @return bool|string
     */
    private function GetLabel()
        /************************************************************/
    {
        if ($this->SkipBlancs() == false)
            return false;

        if ($this->buffer[0] == '@') {
            $param = strtok($this->buffer, " ,/)\t\r\n");
        } else
            $this->Err("Un label doit commencer par @ : '" . substr($this->buffer, 0, 25) . "'\n");
        // Recherche %
        $this->buffer = substr($this->buffer, strlen($param));
        return $param;
    }

    /**
     * @return bool|string
     */
    private function GetTexte()
        /************************************************************/
    {
        $text = false;

        if ($this->SkipBlancs() == false)
            return false;

        if ($this->buffer[0] == "\"") { // Trouvé début
            $i = 1;
            while ($i < strlen($this->buffer) && $this->buffer[$i] != "\"")
                $i++;
            if ($i < strlen($this->buffer))
                $text = substr($this->buffer, 1, $i - 1);
        }
        $this->buffer = substr($this->buffer, strlen($text) + 2);
        return $text;
    }

    /**
     * @param $text
     */
    private function puttemplate($text)
    {
        if ($this->fil == false)
            $this->Err("Fichier template non ouvert");
        fwrite($this->fil, $text);
    }

    /**
     * @param $file
     * @return bool
     */
    private function opentemplate($file)
    {
        $this->fil = fopen($file, "wt");
        if ($this->fil == false) {
            $this->Err("Ouverture de template");
            return false;
        }
        $this->puttemplate("<?php\n");
        return true;
    }

    /**
     * @return bool
     */
    private function closetemplate()
    {
        $this->puttemplate("?>\n");
        fclose($this->fil);
        return true;
    }

    private function parse($x, $y, $lx, $ly, $boxcolor = 0)
    {
        $this->recurs++;

        while ($tok = $this->GetToken()) {
            $flink = false;
            $fframe = false;
            switch ($tok) {

                case "frame":
                    $fframe = true;

                case "box":
                    $this->cr();
                    $this->e("box ");
                    $this->GetLPar();
                    $newx = $this->GetNum($x, $lx);
                    $this->GetVirg();
                    $newy = $this->GetNum($y, $ly);
                    $this->GetVirg();
                    $newlx = $this->GetNum($x, $lx) - $x;
                    $this->GetVirg();
                    $newly = $this->GetNum($y, $ly) - $y;
                    $this->GetRPar();
                    // Gen Tableau
                    if (!$fframe)
                        $this->puttemplate("\$this->bx[] = ['typ' => 'box','x' => $newx,'y' => $newy,'lx' => $newlx,'ly' => $newly,'bcol' => $boxcolor];\n");
                    //else
                    //puttemplate("/*\$bx[] = array('typ' => 'frame','x' => $newx,'y' => $newy,'lx' => $newlx,'ly' => $newly,'bcol' => $boxcolor);*/\n");

                    $this->SetLineWidth(0.25);
                    if (!$fframe)
                        $this->Rect($newx, $newy, $newlx, $newly, 'D');
                    //$pdf->cell($lx,$ly,"essai",1);*/
                    if ($this->GetLBrace(false)) { // Trouvé accolade
                        $this->GetLBrace();
                        $table = $this->parse($newx, $newy, $newlx, $newly, $boxcolor);
                    }
                    break;

                case "}":
                    $this->recurs--;
                    $this->cr();
                    $this->e("}");
                    return;

                case "link":
                    $flink = true;

                case "text":
                    $this->cr();
                    $this->e("text");
                    $this->GetLPar();
                    $police = $this->GetTexte();
                    $this->GetVirg();
                    $this->e("[$police]");
                    $taille = $this->GetNum(0, 0);
                    $this->GetVirg();
                    $this->e("[$taille]");
                    $mode = $this->GetTexte();
                    $this->GetVirg();
                    $this->e("[$mode]");
                    $color = $this->GetNum(0, 0);
                    $this->GetVirg();
                    $this->e("[$color]");
                    $label = $this->GetTexte();
                    $this->e("[$label]");
                    if ($label[0] == '@') { // Label
                        if (!isset($this->tablabel[$label])) {
                            $this->tablabel[$label] = $label;
                            $this->puttemplate("\$this->tablabel['$label'] = false; // Non initialisé\n");
                        }
                        $textaff = $this->tablabel[$label];
                    } else
                        $textaff = $label;
                    $this->GetRPar();
                    // Dépouillage du mode
                    $tabmodes = explode(":", $mode);
                    $align = "";
                    $style = "";
                    foreach ($tabmodes as $key) {
                        switch ($key) {
                            case "gras":
                                $style .= 'B';
                                break;
                            case "souligné":
                                $style .= 'U';
                                break;
                            case "italique":
                                $style .= 'I';
                                break;
                            case "gauche":
                                $align = 'L';
                                break;
                            case "centré":
                                $align = 'C';
                                break;
                            case "droite":
                                $align = 'R';
                                break;
                            default:
                                $this->Err("Style inconnu : [$key]");
                                break;
                        }
                    }
                    if ($flink)
                        $this->puttemplate("\$this->bx[] = ['typ' => 'link','face' => '$police','size' => $taille,'style' => '$style','align' => '$align', 'color' => $color," .
                            "'x' => $x, 'y' => $y, 'lx' => $lx, 'ly' => $ly, 'text' => '" . addslashes($label) . "'];\n");
                    else
                        $this->puttemplate("\$this->bx[] = ['typ' => 'text','face' => '$police','size' => $taille,'style' => '$style','align' => '$align', 'color' => $color," .
                            "'x' => $x, 'y' => $y, 'lx' => $lx, 'ly' => $ly, 'text' => '" . addslashes($label) . "'];\n");
                    $this->SetFont($police, $style, $taille);
                    $red = ($color & 0xff0000) >> 16;
                    $grn = ($color & 0x00ff00) >> 8;
                    $blu = ($color & 0x0000ff);
                    $this->SetTextColor($red, $grn, $blu);
                    if ($flink) {
                        $this->SetXY($x, $y);
                        $this->Cell($lx, $this->FontSize, $textaff, 0, 0, $align, false, $textaff);
                    } else {
                        $height = $this->height($lx, $textaff);
                        $htext = $height * $this->FontSize;
                        $sy = ($ly - $htext) / 2 + $y;
                        $this->SetXY($x, $sy);
                        $this->MultiCell($lx, $this->FontSize, $textaff, 0, $align);
                    }
                    break;

                case "setlabel":
                    $this->cr();
                    $this->e("setlabel");
                    $this->GetLPar();
                    $label = $this->GetLabel();
                    $this->GetVirg();
                    $this->e("[$label]");
                    $text = $this->GetTexte();
                    $this->e("[$text]");
                    $this->GetRPar();
                    $this->tablabel[$label] = $text;
                    $this->puttemplate("\$this->tablabel['$label'] = \"" . addslashes($text) . "\";\n");
                    break;

                case "image":
                    $this->cr();
                    $this->e("image");
                    $this->GetLPar();
                    $nx = $this->GetNum($x, $lx);
                    $this->GetVirg();
                    $this->e("[$x]");
                    $ny = $this->GetNum($y, $ly);
                    $this->GetVirg();
                    $this->e("[$y]");
                    $nlx = $this->GetNum($x, $lx) - $x;
                    $this->GetVirg();
                    $this->e("[$lx]");
                    $nly = $this->GetNum($y, $ly) - $y;
                    $this->GetVirg();
                    $this->e("[$ly]");
                    $label = $this->GetTexte();
                    $this->e("[$label]");
                    if ($label[0] == '@') { // Label
                        if (!isset($this->tablabel[$label])) {
                            $this->tablabel[$label] = $label;
                            $this->puttemplate("\$this->tablabel['$label'] = false; // Non initialisé\n");
                        }
                        $textaff = $this->tablabel[$label];
                    } else
                        $textaff = $label;
                    $this->GetRPar();
                    $this->puttemplate("\$this->bx[] = ['typ' => 'image','x' => $nx,'y' => $ny,'lx' => $nlx,'ly' => $nly,'label' => '$label'];\n");
                    if ($textaff[0] != '@')
                        $this->Image($textaff, $nx, $ny,/*$nlx*/
                            0, $nly);
                    else {
                        $this->SetFont("arial", '', 10);
                        $red = 0;
                        $grn = 0;
                        $blu = 0;
                        $this->SetTextColor($red, $grn, $blu);
                        $this->SetXY($x, $y);
                        $this->Cell($nx, $this->FontSize, $textaff, 0, 0, 'C', false);
                    }
                    break;

                case "colorbox":
                    $this->cr();
                    $this->e("colorbox");
                    $this->GetLPar();
                    $boxcolor = $this->GetNum(0, 0);
                    $this->GetRPar();
                    $red = ($boxcolor & 0xff0000) >> 16;
                    $grn = ($boxcolor & 0x00ff00) >> 8;
                    $blu = ($boxcolor & 0x0000ff);
                    $this->SetDrawColor($red, $grn, $blu);
                    $this->puttemplate("\$this->bx[] = ['typ' => 'colorbox','red' => $red,'grn' => $grn,'blu' => $blu];\n");
                    break;

                default;
                    $this->cr();
                    $this->Err("inconnu : [" . $tok . "]");
                    break;
            }
        }
    }

    /**
     * Fonction à appeler pour génerer le fichier PDF
     * @param string $template
     */
    public function GenererTemplate(string $template)
    {
        if (!$this->openfile($template . ".txt"))
            $this->Err("Ouverture du fichier box\n");

        if (!$this->opentemplate($template . ".php"))
            $this->Err("Ouverture du fichier template\n");

        $this->parse(0, 0, 0, 0);

        $this->Output($template . ".pdf", 'D');

        $this->closetemplate();
    }

    /**
     * GenPDF constructor.
     * @param string $orientation
     * @param string $unit
     * @param string $size
     */
    public function __construct(string $orientation = 'P', string $unit = 'mm', string $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);

        $this->AddFont('Comic', '', 'comic.php');
        $this->AddFont('Comic', 'B', 'comicbd.php');
        $this->AddPage();
        $this->SetMargins(0, 0);
        $this->SetFont('Times', '', 12);
        $this->SetAutoPageBreak(false);
    }
}
/*
$insc = new GenPDF('P', 'mm', "A4");
$insc->GenererTemplate("fiche_insc");
$fact = new GenPDF('P', 'mm', "A4");
$fact->GenererTemplate("facture");
*/
