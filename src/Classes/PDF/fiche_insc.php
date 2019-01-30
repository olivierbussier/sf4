<?php

namespace App\Classes\PDF;

class fiche_insc
{

    private $bx = [];
    private $tablabel = [];

    public function __construct()
    {
        $this->bx[] = ['typ' => 'colorbox', 'red' => 255, 'grn' => 255, 'blu' => 255];
        $this->tablabel['@photo'] = "photo.jpg";
        $this->tablabel['@reglok'] = "Je reconnais avoir pris connaissance du r�glement int�rieur du GUC. Ce dernier est disponible sur le site web";
        $this->tablabel['@regllink'] = "http://guc-plongee.net/docs/ReglementInterieur.pdf";
        $this->tablabel['@templatecertiflien'] = "http://www.guc-plongee.net/docs/CertMed.pdf";
        $this->tablabel['@dipl1'] = "";
        $this->tablabel['@dipl2'] = "";
        $this->tablabel['@dipl3'] = "";
        $this->tablabel['@dipl4'] = "";
        $this->tablabel['@dipl5'] = "";
        $this->tablabel['@dipl6'] = "";
        $this->tablabel['@doc1'] = "";
        $this->tablabel['@doc2'] = "";
        $this->tablabel['@doc3'] = "";
        $this->tablabel['@doc4'] = "";
        $this->tablabel['@doc5'] = "";
        $this->tablabel['@doc6'] = "";
        $this->tablabel['@doc7'] = "";
        $this->tablabel['@doc8'] = "";
        $this->tablabel['@doc9'] = "";
        $this->tablabel['@doc10'] = "";
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 10, 'lx' => 190, 'ly' => 277, 'bcol' => 16777215];
        $this->bx[] = ['typ' => 'colorbox', 'red' => 0, 'grn' => 0, 'blu' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 10, 'lx' => 190, 'ly' => 20, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 10, 'lx' => 20, 'ly' => 20, 'bcol' => 0];
        $this->bx[] = ['typ' => 'image', 'x' => 10.2, 'y' => 10.2, 'lx' => 19.6, 'ly' => 19.6, 'label' => '../src/Classes/PDF/logo.gif'];
        $this->bx[] = ['typ' => 'box', 'x' => 30, 'y' => 10, 'lx' => 35, 'ly' => 20, 'bcol' => 0];
        $this->tablabel['@texaninscr'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 18, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 30, 'y' => 10, 'lx' => 35, 'ly' => 20, 'text' => '@texaninscr'];
        $this->bx[] = ['typ' => 'box', 'x' => 65, 'y' => 10, 'lx' => 76, 'ly' => 20, 'bcol' => 0];
        $this->tablabel['@textnomadh'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 18, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 65, 'y' => 10, 'lx' => 76, 'ly' => 20, 'text' => '@textnomadh'];
        $this->bx[] = ['typ' => 'box', 'x' => 141, 'y' => 10, 'lx' => 27, 'ly' => 20, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 141, 'y' => 10, 'lx' => 27, 'ly' => 6.666, 'bcol' => 0];
        $this->tablabel['@flag1'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 141, 'y' => 10, 'lx' => 27, 'ly' => 6.666, 'text' => '@flag1'];
        $this->bx[] = ['typ' => 'box', 'x' => 141, 'y' => 16.666, 'lx' => 27, 'ly' => 6.666, 'bcol' => 0];
        $this->tablabel['@flag2'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 141, 'y' => 16.666, 'lx' => 27, 'ly' => 6.666, 'text' => '@flag2'];
        $this->bx[] = ['typ' => 'box', 'x' => 141, 'y' => 23.332, 'lx' => 27, 'ly' => 6.666, 'bcol' => 0];
        $this->tablabel['@flag3'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 141, 'y' => 23.332, 'lx' => 27, 'ly' => 6.666, 'text' => '@flag3'];
        $this->bx[] = ['typ' => 'box', 'x' => 168, 'y' => 10, 'lx' => 32, 'ly' => 20, 'bcol' => 0];
        $this->tablabel['@textnumadh'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 34, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 168, 'y' => 10, 'lx' => 32, 'ly' => 20, 'text' => '@textnumadh'];
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 32, 'lx' => 190, 'ly' => 60, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 32, 'lx' => 142.5, 'ly' => 60, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 32, 'lx' => 142.5, 'ly' => 7, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 14, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 10, 'y' => 32, 'lx' => 142.5, 'ly' => 7, 'text' => 'R�capitulatif des documents � fournir'];
        $this->bx[] = ['typ' => 'box', 'x' => 11, 'y' => 40, 'lx' => 139.65, 'ly' => 45, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 11, 'y' => 40, 'lx' => 6.9825, 'ly' => 5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 17.9825, 'y' => 40, 'lx' => 132.6675, 'ly' => 5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 8, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 17.9825, 'y' => 40, 'lx' => 132.6675, 'ly' => 5, 'text' => '@doc1'];
        $this->bx[] = ['typ' => 'box', 'x' => 11, 'y' => 45, 'lx' => 6.9825, 'ly' => 5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 17.9825, 'y' => 45, 'lx' => 132.6675, 'ly' => 5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 8, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 17.9825, 'y' => 45, 'lx' => 132.6675, 'ly' => 5, 'text' => '@doc2'];
        $this->bx[] = ['typ' => 'box', 'x' => 11, 'y' => 50, 'lx' => 6.9825, 'ly' => 5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 17.9825, 'y' => 50, 'lx' => 132.6675, 'ly' => 5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 8, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 17.9825, 'y' => 50, 'lx' => 132.6675, 'ly' => 5, 'text' => '@doc3'];
        $this->bx[] = ['typ' => 'box', 'x' => 11, 'y' => 55, 'lx' => 6.9825, 'ly' => 5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 17.9825, 'y' => 55, 'lx' => 132.6675, 'ly' => 5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 8, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 17.9825, 'y' => 55, 'lx' => 132.6675, 'ly' => 5, 'text' => '@doc4'];
        $this->bx[] = ['typ' => 'box', 'x' => 11, 'y' => 60, 'lx' => 6.9825, 'ly' => 5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 17.9825, 'y' => 60, 'lx' => 132.6675, 'ly' => 5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 8, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 17.9825, 'y' => 60, 'lx' => 132.6675, 'ly' => 5, 'text' => '@doc5'];
        $this->bx[] = ['typ' => 'box', 'x' => 11, 'y' => 65, 'lx' => 6.9825, 'ly' => 5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 17.9825, 'y' => 65, 'lx' => 132.6675, 'ly' => 5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 8, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 17.9825, 'y' => 65, 'lx' => 132.6675, 'ly' => 5, 'text' => '@doc6'];
        $this->bx[] = ['typ' => 'box', 'x' => 11, 'y' => 70, 'lx' => 6.9825, 'ly' => 5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 17.9825, 'y' => 70, 'lx' => 132.6675, 'ly' => 5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 8, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 17.9825, 'y' => 70, 'lx' => 132.6675, 'ly' => 5, 'text' => '@doc7'];
        $this->bx[] = ['typ' => 'box', 'x' => 11, 'y' => 75, 'lx' => 6.9825, 'ly' => 5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 17.9825, 'y' => 75, 'lx' => 132.6675, 'ly' => 5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 8, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 17.9825, 'y' => 75, 'lx' => 132.6675, 'ly' => 5, 'text' => '@doc8'];
        $this->bx[] = ['typ' => 'box', 'x' => 11, 'y' => 80, 'lx' => 6.9825, 'ly' => 5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 17.9825, 'y' => 80, 'lx' => 132.6675, 'ly' => 5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 8, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 17.9825, 'y' => 80, 'lx' => 132.6675, 'ly' => 5, 'text' => '@doc9'];
        $this->bx[] = ['typ' => 'box', 'x' => 11, 'y' => 85, 'lx' => 6.9825, 'ly' => 5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 17.9825, 'y' => 85, 'lx' => 132.6675, 'ly' => 5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 8, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 17.9825, 'y' => 85, 'lx' => 132.6675, 'ly' => 5, 'text' => '@doc10'];
        $this->bx[] = ['typ' => 'box', 'x' => 152.5, 'y' => 32, 'lx' => 47.5, 'ly' => 60, 'bcol' => 0];
        $this->bx[] = ['typ' => 'image', 'x' => 153.4025, 'y' => 32.6, 'lx' => 46.55, 'ly' => 58.8, 'label' => '@photo'];
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 94, 'lx' => 94.05, 'ly' => 80, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 94, 'lx' => 94.05, 'ly' => 10, 'bcol' => 0];
        $this->tablabel['@adhname'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 14, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 10, 'y' => 94, 'lx' => 94.05, 'ly' => 10, 'text' => '@adhname'];
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 104, 'lx' => 32.9175, 'ly' => 10, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 104, 'lx' => 32.9175, 'ly' => 10, 'text' => 'Adresse'];
        $this->bx[] = ['typ' => 'box', 'x' => 42.9175, 'y' => 104, 'lx' => 61.1325, 'ly' => 10, 'bcol' => 0];
        $this->tablabel['@addr'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 42.9175, 'y' => 104, 'lx' => 61.1325, 'ly' => 10, 'text' => '@addr'];
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 114, 'lx' => 32.9175, 'ly' => 6, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 114, 'lx' => 32.9175, 'ly' => 6, 'text' => 'Code Postal'];
        $this->bx[] = ['typ' => 'box', 'x' => 42.9175, 'y' => 114, 'lx' => 61.1325, 'ly' => 6, 'bcol' => 0];
        $this->tablabel['@codep'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 42.9175, 'y' => 114, 'lx' => 61.1325, 'ly' => 6, 'text' => '@codep'];
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 120, 'lx' => 32.9175, 'ly' => 6, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 120, 'lx' => 32.9175, 'ly' => 6, 'text' => 'Ville'];
        $this->bx[] = ['typ' => 'box', 'x' => 42.9175, 'y' => 120, 'lx' => 61.1325, 'ly' => 6, 'bcol' => 0];
        $this->tablabel['@ville'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 42.9175, 'y' => 120, 'lx' => 61.1325, 'ly' => 6, 'text' => '@ville'];
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 126, 'lx' => 32.9175, 'ly' => 6, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 126, 'lx' => 32.9175, 'ly' => 6, 'text' => 'Profession'];
        $this->bx[] = ['typ' => 'box', 'x' => 42.9175, 'y' => 126, 'lx' => 61.1325, 'ly' => 6, 'bcol' => 0];
        $this->tablabel['@profess'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 42.9175, 'y' => 126, 'lx' => 61.1325, 'ly' => 6, 'text' => '@profess'];
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 132, 'lx' => 32.9175, 'ly' => 6, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 132, 'lx' => 32.9175, 'ly' => 6, 'text' => 'Date de naissance'];
        $this->bx[] = ['typ' => 'box', 'x' => 42.9175, 'y' => 132, 'lx' => 61.1325, 'ly' => 6, 'bcol' => 0];
        $this->tablabel['@datnaiss'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 42.9175, 'y' => 132, 'lx' => 61.1325, 'ly' => 6, 'text' => '@datnaiss'];
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 138, 'lx' => 32.9175, 'ly' => 6, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 138, 'lx' => 32.9175, 'ly' => 6, 'text' => 'Tel Fixe'];
        $this->bx[] = ['typ' => 'box', 'x' => 42.9175, 'y' => 138, 'lx' => 61.1325, 'ly' => 6, 'bcol' => 0];
        $this->tablabel['@telfix'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 42.9175, 'y' => 138, 'lx' => 61.1325, 'ly' => 6, 'text' => '@telfix'];
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 144, 'lx' => 32.9175, 'ly' => 6, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 144, 'lx' => 32.9175, 'ly' => 6, 'text' => 'Tel Portable'];
        $this->bx[] = ['typ' => 'box', 'x' => 42.9175, 'y' => 144, 'lx' => 61.1325, 'ly' => 6, 'bcol' => 0];
        $this->tablabel['@telpor'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 42.9175, 'y' => 144, 'lx' => 61.1325, 'ly' => 6, 'text' => '@telpor'];
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 150, 'lx' => 32.9175, 'ly' => 6, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 150, 'lx' => 32.9175, 'ly' => 6, 'text' => 'Adresse mail'];
        $this->bx[] = ['typ' => 'box', 'x' => 42.9175, 'y' => 150, 'lx' => 61.1325, 'ly' => 6, 'bcol' => 0];
        $this->tablabel['@mail'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 42.9175, 'y' => 150, 'lx' => 61.1325, 'ly' => 6, 'text' => '@mail'];
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 156, 'lx' => 32.9175, 'ly' => 6, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 156, 'lx' => 32.9175, 'ly' => 6, 'text' => ' '];
        $this->bx[] = ['typ' => 'box', 'x' => 42.9175, 'y' => 156, 'lx' => 61.1325, 'ly' => 6, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 42.9175, 'y' => 156, 'lx' => 61.1325, 'ly' => 6, 'text' => ' '];
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 162, 'lx' => 32.9175, 'ly' => 6, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 162, 'lx' => 32.9175, 'ly' => 6, 'text' => ' '];
        $this->bx[] = ['typ' => 'box', 'x' => 42.9175, 'y' => 162, 'lx' => 61.1325, 'ly' => 6, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 42.9175, 'y' => 162, 'lx' => 61.1325, 'ly' => 6, 'text' => ' '];
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 168, 'lx' => 32.9175, 'ly' => 6, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 168, 'lx' => 32.9175, 'ly' => 6, 'text' => ' '];
        $this->bx[] = ['typ' => 'box', 'x' => 42.9175, 'y' => 168, 'lx' => 61.1325, 'ly' => 6, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 42.9175, 'y' => 168, 'lx' => 61.1325, 'ly' => 6, 'text' => ' '];
        $this->bx[] = ['typ' => 'box', 'x' => 105.95, 'y' => 94, 'lx' => 94.05, 'ly' => 18, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 105.95, 'y' => 94, 'lx' => 47.025, 'ly' => 18, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 105.95, 'y' => 94, 'lx' => 47.025, 'ly' => 5.994, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 105.95, 'y' => 94, 'lx' => 47.025, 'ly' => 5.994, 'text' => 'Niveau actuel'];
        $this->bx[] = ['typ' => 'box', 'x' => 105.95, 'y' => 99.994, 'lx' => 23.5125, 'ly' => 5.994, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 105.95, 'y' => 99.994, 'lx' => 23.5125, 'ly' => 5.994, 'text' => 'Scaphandre'];
        $this->bx[] = ['typ' => 'box', 'x' => 129.4625, 'y' => 99.994, 'lx' => 23.5125, 'ly' => 5.994, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 129.4625, 'y' => 99.994, 'lx' => 23.5125, 'ly' => 5.994, 'text' => 'Apn�e'];
        $this->bx[] = ['typ' => 'box', 'x' => 105.95, 'y' => 105.988, 'lx' => 23.5125, 'ly' => 5.994, 'bcol' => 0];
        $this->tablabel['@nivscaph'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 105.95, 'y' => 105.988, 'lx' => 23.5125, 'ly' => 5.994, 'text' => '@nivscaph'];
        $this->bx[] = ['typ' => 'box', 'x' => 129.4625, 'y' => 105.988, 'lx' => 23.5125, 'ly' => 5.994, 'bcol' => 0];
        $this->tablabel['@nivapnee'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 129.4625, 'y' => 105.988, 'lx' => 23.5125, 'ly' => 5.994, 'text' => '@nivapnee'];
        $this->bx[] = ['typ' => 'box', 'x' => 152.975, 'y' => 94, 'lx' => 47.025, 'ly' => 18, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 152.975, 'y' => 94, 'lx' => 47.025, 'ly' => 11.988, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 152.975, 'y' => 94, 'lx' => 47.025, 'ly' => 11.988, 'text' => 'Activit� pr�vue cette ann�e'];
        $this->bx[] = ['typ' => 'box', 'x' => 152.975, 'y' => 105.988, 'lx' => 47.025, 'ly' => 5.994, 'bcol' => 0];
        $this->tablabel['@activite'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 152.975, 'y' => 105.988, 'lx' => 47.025, 'ly' => 5.994, 'text' => '@activite'];
        $this->bx[] = ['typ' => 'box', 'x' => 105.95, 'y' => 114, 'lx' => 94.05, 'ly' => 12, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 105.95, 'y' => 114, 'lx' => 94.05, 'ly' => 6, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 105.95, 'y' => 114, 'lx' => 94.05, 'ly' => 6, 'text' => 'Autres dipl�mes'];
        $this->bx[] = ['typ' => 'box', 'x' => 105.95, 'y' => 120, 'lx' => 15.6123, 'ly' => 6, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 105.95, 'y' => 120, 'lx' => 15.6123, 'ly' => 6, 'text' => '@dipl1'];
        $this->bx[] = ['typ' => 'box', 'x' => 121.5623, 'y' => 120, 'lx' => 15.6123, 'ly' => 6, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 121.5623, 'y' => 120, 'lx' => 15.6123, 'ly' => 6, 'text' => '@dipl2'];
        $this->bx[] = ['typ' => 'box', 'x' => 137.1746, 'y' => 120, 'lx' => 15.6123, 'ly' => 6, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 137.1746, 'y' => 120, 'lx' => 15.6123, 'ly' => 6, 'text' => '@dipl3'];
        $this->bx[] = ['typ' => 'box', 'x' => 152.7869, 'y' => 120, 'lx' => 15.6123, 'ly' => 6, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 152.7869, 'y' => 120, 'lx' => 15.6123, 'ly' => 6, 'text' => '@dipl4'];
        $this->bx[] = ['typ' => 'box', 'x' => 168.3992, 'y' => 120, 'lx' => 15.6123, 'ly' => 6, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 168.3992, 'y' => 120, 'lx' => 15.6123, 'ly' => 6, 'text' => '@dipl5'];
        $this->bx[] = ['typ' => 'box', 'x' => 184.0115, 'y' => 120, 'lx' => 15.9885, 'ly' => 6, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 184.0115, 'y' => 120, 'lx' => 15.9885, 'ly' => 6, 'text' => '@dipl6'];
        $this->bx[] = ['typ' => 'box', 'x' => 105.95, 'y' => 128, 'lx' => 94.05, 'ly' => 12, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 105.95, 'y' => 128, 'lx' => 94.05, 'ly' => 6, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 105.95, 'y' => 128, 'lx' => 94.05, 'ly' => 6, 'text' => 'Je participe � la vie du club (avec l\'accord du pr�sident)'];
        $this->bx[] = ['typ' => 'box', 'x' => 105.95, 'y' => 134, 'lx' => 37.62, 'ly' => 6, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 105.95, 'y' => 134, 'lx' => 37.62, 'ly' => 6, 'text' => 'B�n�vole'];
        $this->bx[] = ['typ' => 'box', 'x' => 143.57, 'y' => 134, 'lx' => 9.405, 'ly' => 6, 'bcol' => 0];
        $this->tablabel['@choixbene'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 143.57, 'y' => 134, 'lx' => 9.405, 'ly' => 6, 'text' => '@choixbene'];
        $this->bx[] = ['typ' => 'box', 'x' => 152.975, 'y' => 134, 'lx' => 37.62, 'ly' => 6, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 152.975, 'y' => 134, 'lx' => 37.62, 'ly' => 6, 'text' => 'Encadrant'];
        $this->bx[] = ['typ' => 'box', 'x' => 190.595, 'y' => 134, 'lx' => 9.405, 'ly' => 6, 'bcol' => 0];
        $this->tablabel['@choixenca'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 190.595, 'y' => 134, 'lx' => 9.405, 'ly' => 6, 'text' => '@choixenca'];
        $this->bx[] = ['typ' => 'box', 'x' => 105.95, 'y' => 144, 'lx' => 94.05, 'ly' => 30, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 105.95, 'y' => 144, 'lx' => 94.05, 'ly' => 7.5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 105.95, 'y' => 144, 'lx' => 94.05, 'ly' => 7.5, 'text' => 'Personne � pr�venir en cas d\'accident'];
        $this->bx[] = ['typ' => 'box', 'x' => 105.95, 'y' => 151.5, 'lx' => 18.81, 'ly' => 7.5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'R', 'color' => 0, 'x' => 105.95, 'y' => 151.5, 'lx' => 18.81, 'ly' => 7.5, 'text' => 'Nom'];
        $this->bx[] = ['typ' => 'box', 'x' => 124.76, 'y' => 151.5, 'lx' => 75.24, 'ly' => 7.5, 'bcol' => 0];
        $this->tablabel['@nomacc'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 124.76, 'y' => 151.5, 'lx' => 75.24, 'ly' => 7.5, 'text' => '@nomacc'];
        $this->bx[] = ['typ' => 'box', 'x' => 105.95, 'y' => 159, 'lx' => 18.81, 'ly' => 7.5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'R', 'color' => 0, 'x' => 105.95, 'y' => 159, 'lx' => 18.81, 'ly' => 7.5, 'text' => 'Pr�nom'];
        $this->bx[] = ['typ' => 'box', 'x' => 124.76, 'y' => 159, 'lx' => 75.24, 'ly' => 7.5, 'bcol' => 0];
        $this->tablabel['@prenomacc'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 124.76, 'y' => 159, 'lx' => 75.24, 'ly' => 7.5, 'text' => '@prenomacc'];
        $this->bx[] = ['typ' => 'box', 'x' => 105.95, 'y' => 166.5, 'lx' => 18.81, 'ly' => 7.5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'R', 'color' => 0, 'x' => 105.95, 'y' => 166.5, 'lx' => 18.81, 'ly' => 7.5, 'text' => 'Tel Fixe.'];
        $this->bx[] = ['typ' => 'box', 'x' => 124.76, 'y' => 166.5, 'lx' => 28.215, 'ly' => 7.5, 'bcol' => 0];
        $this->tablabel['@telfixacc'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 124.76, 'y' => 166.5, 'lx' => 28.215, 'ly' => 7.5, 'text' => '@telfixacc'];
        $this->bx[] = ['typ' => 'box', 'x' => 152.975, 'y' => 166.5, 'lx' => 18.81, 'ly' => 7.5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'R', 'color' => 0, 'x' => 152.975, 'y' => 166.5, 'lx' => 18.81, 'ly' => 7.5, 'text' => 'Tel Port.'];
        $this->bx[] = ['typ' => 'box', 'x' => 171.785, 'y' => 166.5, 'lx' => 28.215, 'ly' => 7.5, 'bcol' => 0];
        $this->tablabel['@telporacc'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 171.785, 'y' => 166.5, 'lx' => 28.215, 'ly' => 7.5, 'text' => '@telporacc'];
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 175, 'lx' => 61.75, 'ly' => 18, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 175, 'lx' => 24.7, 'ly' => 5.994, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 10, 'y' => 175, 'lx' => 24.7, 'ly' => 5.994, 'text' => 'CAESUG'];
        $this->bx[] = ['typ' => 'box', 'x' => 34.7, 'y' => 175, 'lx' => 6.175, 'ly' => 5.994, 'bcol' => 0];
        $this->tablabel['@choixcaesug'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 34.7, 'y' => 175, 'lx' => 6.175, 'ly' => 5.994, 'text' => '@choixcaesug'];
        $this->bx[] = ['typ' => 'box', 'x' => 40.875, 'y' => 175, 'lx' => 24.7, 'ly' => 5.994, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 40.875, 'y' => 175, 'lx' => 24.7, 'ly' => 5.994, 'text' => 'Facture'];
        $this->bx[] = ['typ' => 'box', 'x' => 65.575, 'y' => 175, 'lx' => 6.175, 'ly' => 5.994, 'bcol' => 0];
        $this->tablabel['@choixfac'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 65.575, 'y' => 175, 'lx' => 6.175, 'ly' => 5.994, 'text' => '@choixfac'];
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 180.994, 'lx' => 24.7, 'ly' => 5.994, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 10, 'y' => 180.994, 'lx' => 24.7, 'ly' => 5.994, 'text' => 'Carte GUC'];
        $this->bx[] = ['typ' => 'box', 'x' => 34.7, 'y' => 180.994, 'lx' => 6.175, 'ly' => 5.994, 'bcol' => 0];
        $this->tablabel['@choixguc'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 34.7, 'y' => 180.994, 'lx' => 6.175, 'ly' => 5.994, 'text' => '@choixguc'];
        $this->bx[] = ['typ' => 'box', 'x' => 40.875, 'y' => 180.994, 'lx' => 24.7, 'ly' => 5.994, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 40.875, 'y' => 180.994, 'lx' => 24.7, 'ly' => 5.994, 'text' => 'Carte SIUAPS'];
        $this->bx[] = ['typ' => 'box', 'x' => 65.575, 'y' => 180.994, 'lx' => 6.175, 'ly' => 5.994, 'bcol' => 0];
        $this->tablabel['@choixsiuaps'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 65.575, 'y' => 180.994, 'lx' => 6.175, 'ly' => 5.994, 'text' => '@choixsiuaps'];
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 186.988, 'lx' => 24.7, 'ly' => 5.994, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 10, 'y' => 186.988, 'lx' => 24.7, 'ly' => 5.994, 'text' => 'Pr�t mat�riel'];
        $this->bx[] = ['typ' => 'box', 'x' => 34.7, 'y' => 186.988, 'lx' => 6.175, 'ly' => 5.994, 'bcol' => 0];
        $this->tablabel['@choixmat'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 34.7, 'y' => 186.988, 'lx' => 6.175, 'ly' => 5.994, 'text' => '@choixmat'];
        $this->bx[] = ['typ' => 'box', 'x' => 40.875, 'y' => 186.988, 'lx' => 24.7, 'ly' => 5.994, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 40.875, 'y' => 186.988, 'lx' => 24.7, 'ly' => 5.994, 'text' => 'Etudiant'];
        $this->bx[] = ['typ' => 'box', 'x' => 65.575, 'y' => 186.988, 'lx' => 6.175, 'ly' => 5.994, 'bcol' => 0];
        $this->tablabel['@etudiant'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 65.575, 'y' => 186.988, 'lx' => 6.175, 'ly' => 5.994, 'text' => '@etudiant'];
        $this->bx[] = ['typ' => 'box', 'x' => 73.65, 'y' => 175, 'lx' => 61.75, 'ly' => 18, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 73.65, 'y' => 175, 'lx' => 27.7875, 'ly' => 5.994, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 73.65, 'y' => 175, 'lx' => 27.7875, 'ly' => 5.994, 'text' => 'Licence FFESSM'];
        $this->bx[] = ['typ' => 'box', 'x' => 101.4375, 'y' => 175, 'lx' => 33.9625, 'ly' => 5.994, 'bcol' => 0];
        $this->tablabel['@choixffessm'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 101.4375, 'y' => 175, 'lx' => 33.9625, 'ly' => 5.994, 'text' => '@choixffessm'];
        $this->bx[] = ['typ' => 'box', 'x' => 73.65, 'y' => 180.994, 'lx' => 27.7875, 'ly' => 5.994, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 73.65, 'y' => 180.994, 'lx' => 27.7875, 'ly' => 5.994, 'text' => 'Assurance AXA'];
        $this->bx[] = ['typ' => 'box', 'x' => 101.4375, 'y' => 180.994, 'lx' => 33.9625, 'ly' => 5.994, 'bcol' => 0];
        $this->tablabel['@choixaxa'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 101.4375, 'y' => 180.994, 'lx' => 33.9625, 'ly' => 5.994, 'text' => '@choixaxa'];
        $this->bx[] = ['typ' => 'box', 'x' => 73.65, 'y' => 186.988, 'lx' => 27.7875, 'ly' => 5.994, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 73.65, 'y' => 186.988, 'lx' => 27.7875, 'ly' => 5.994, 'text' => 'Cotisation GUC'];
        $this->bx[] = ['typ' => 'box', 'x' => 101.4375, 'y' => 186.988, 'lx' => 33.9625, 'ly' => 5.994, 'bcol' => 0];
        $this->tablabel['@choixcotguc'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 101.4375, 'y' => 186.988, 'lx' => 33.9625, 'ly' => 5.994, 'text' => '@choixcotguc'];
        $this->bx[] = ['typ' => 'box', 'x' => 137.3, 'y' => 175, 'lx' => 62.7, 'ly' => 18, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 137.3, 'y' => 175, 'lx' => 56.43, 'ly' => 5.994, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 137.3, 'y' => 175, 'lx' => 56.43, 'ly' => 5.994, 'text' => 'R�duction famille'];
        $this->bx[] = ['typ' => 'box', 'x' => 193.73, 'y' => 175, 'lx' => 6.27, 'ly' => 5.994, 'bcol' => 0];
        $this->tablabel['@choixfam'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 193.73, 'y' => 175, 'lx' => 6.27, 'ly' => 5.994, 'text' => '@choixfam'];
        $this->bx[] = ['typ' => 'box', 'x' => 137.3, 'y' => 180.994, 'lx' => 37.62, 'ly' => 5.994, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 137.3, 'y' => 180.994, 'lx' => 37.62, 'ly' => 5.994, 'text' => 'Date Certif. m�dical'];
        $this->bx[] = ['typ' => 'box', 'x' => 174.92, 'y' => 180.994, 'lx' => 25.08, 'ly' => 5.994, 'bcol' => 0];
        $this->tablabel['@datecertif'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 174.92, 'y' => 180.994, 'lx' => 25.08, 'ly' => 5.994, 'text' => '@datecertif'];
        $this->bx[] = ['typ' => 'box', 'x' => 137.3, 'y' => 186.988, 'lx' => 37.62, 'ly' => 5.994, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 137.3, 'y' => 186.988, 'lx' => 37.62, 'ly' => 5.994, 'text' => 'Intol�rence Aspirine'];
        $this->bx[] = ['typ' => 'box', 'x' => 174.92, 'y' => 186.988, 'lx' => 25.08, 'ly' => 5.994, 'bcol' => 0];
        $this->tablabel['@intolasp'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 174.92, 'y' => 186.988, 'lx' => 25.08, 'ly' => 5.994, 'text' => '@intolasp'];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 10, 'y' => 195, 'lx' => 190, 'ly' => 5, 'text' => '@reglok'];
        $this->bx[] = ['typ' => 'link', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'C', 'color' => 255, 'x' => 10, 'y' => 200, 'lx' => 190, 'ly' => 5, 'text' => '@regllink'];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 207, 'lx' => 60.8, 'ly' => 5, 'text' => 'certificat m�dical :'];
        $this->bx[] = ['typ' => 'link', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'L', 'color' => 255, 'x' => 70.8, 'y' => 207, 'lx' => 127.3, 'ly' => 5, 'text' => '@templatecertiflien'];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 212, 'lx' => 60.8, 'ly' => 5, 'text' => 'Couvertures des assurances AXA :'];
        $this->tablabel['@axalien'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'link', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'L', 'color' => 255, 'x' => 70.8, 'y' => 212, 'lx' => 127.3, 'ly' => 5, 'text' => '@axalien'];
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 220, 'lx' => 93.1, 'ly' => 55, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 220, 'lx' => 93.1, 'ly' => 5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 10, 'y' => 220, 'lx' => 93.1, 'ly' => 5, 'text' => 'Signature du tuteur l�gal ou du parent pour les mineurs'];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 10.931, 'y' => 226, 'lx' => 26.999, 'ly' => 5, 'text' => 'Nom Pr�nom'];
        $this->tablabel['@tutorname'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 37.93, 'y' => 226, 'lx' => 64.239, 'ly' => 5, 'text' => '@tutorname'];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 10.931, 'y' => 232, 'lx' => 26.999, 'ly' => 5, 'text' => 'Lien de parent� :'];
        $this->tablabel['@lienparen'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 37.93, 'y' => 232, 'lx' => 64.239, 'ly' => 5, 'text' => '@lienparen'];
        $this->bx[] = ['typ' => 'box', 'x' => 106.9, 'y' => 220, 'lx' => 93.1, 'ly' => 55, 'bcol' => 0];
        $this->bx[] = ['typ' => 'box', 'x' => 106.9, 'y' => 220, 'lx' => 93.1, 'ly' => 5, 'bcol' => 0];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 106.9, 'y' => 220, 'lx' => 93.1, 'ly' => 5, 'text' => 'Signature de l�adh�rent'];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 107.831, 'y' => 226, 'lx' => 26.999, 'ly' => 5, 'text' => 'Nom Pr�nom'];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 134.83, 'y' => 226, 'lx' => 64.239, 'ly' => 5, 'text' => '@adhname'];
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 107.831, 'y' => 232, 'lx' => 26.999, 'ly' => 5, 'text' => 'Date :'];
        $this->tablabel['@datejour'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 134.83, 'y' => 232, 'lx' => 64.239, 'ly' => 5, 'text' => '@datejour'];
        $this->tablabel['@infobas'] = false; // Non initialis�
        $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'L', 'color' => 0, 'x' => 10, 'y' => 275, 'lx' => 190, 'ly' => 15, 'text' => '@infobas'];
    }
}
