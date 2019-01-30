<?php

namespace App\Classes\PDF;

class facture
{
    private $bx = [];
    private $tablabel = [];

function __construct()
{
    $this->bx[] = ['typ' => 'colorbox', 'red' => 255, 'grn' => 255, 'blu' => 255];
    $this->tablabel['@photo'] = "photo.jpg";
    $this->tablabel['@ad1'] = "";
    $this->tablabel['@ad2'] = "";
    $this->tablabel['@ad3'] = "";
    $this->tablabel['@ad4'] = "";
    $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 10, 'lx' => 190, 'ly' => 277, 'bcol' => 16777215];
    $this->bx[] = ['typ' => 'colorbox', 'red' => 0, 'grn' => 0, 'blu' => 0];
    $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 10, 'lx' => 190, 'ly' => 20, 'bcol' => 0];
    $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 10, 'lx' => 20, 'ly' => 20, 'bcol' => 0];
    $this->bx[] = ['typ' => 'image', 'x' => 10.2, 'y' => 10.2, 'lx' => 19.6, 'ly' => 19.6, 'label' => '../pdf/logo.gif'];
    $this->bx[] = ['typ' => 'box', 'x' => 30, 'y' => 10, 'lx' => 35, 'ly' => 20, 'bcol' => 0];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 18, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 30, 'y' => 10, 'lx' => 35, 'ly' => 20, 'text' => 'GUC Plongée'];
    $this->bx[] = ['typ' => 'box', 'x' => 65, 'y' => 10, 'lx' => 50, 'ly' => 20, 'bcol' => 0];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 30, 'style' => '', 'align' => 'C', 'color' => 0, 'x' => 65, 'y' => 10, 'lx' => 50, 'ly' => 20, 'text' => 'Facture'];
    $this->bx[] = ['typ' => 'box', 'x' => 115, 'y' => 10, 'lx' => 85, 'ly' => 20, 'bcol' => 0];
    $this->tablabel['@reffact'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 34, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 115, 'y' => 10, 'lx' => 85, 'ly' => 20, 'text' => '@reffact'];
    $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 35, 'lx' => 93.1, 'ly' => 40, 'bcol' => 0];
    $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 35, 'lx' => 93.1, 'ly' => 8, 'bcol' => 0];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 16, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 10, 'y' => 35, 'lx' => 93.1, 'ly' => 8, 'text' => 'Emetteur'];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 14, 'style' => 'B', 'align' => 'L', 'color' => 0, 'x' => 10, 'y' => 45, 'lx' => 93.1, 'ly' => 6, 'text' => 'GUC Plongée'];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 14, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 10, 'y' => 51, 'lx' => 93.1, 'ly' => 6, 'text' => 'Piscine Universitaire'];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 14, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 10, 'y' => 57, 'lx' => 93.1, 'ly' => 6, 'text' => 'Avenue de la piscine'];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 14, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 10, 'y' => 63, 'lx' => 93.1, 'ly' => 6, 'text' => 'Domaine universitaire'];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 14, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 10, 'y' => 69, 'lx' => 93.1, 'ly' => 6, 'text' => '38402 Saint Martin d\'Hères'];
    $this->bx[] = ['typ' => 'box', 'x' => 106.9, 'y' => 35, 'lx' => 93.1, 'ly' => 40, 'bcol' => 0];
    $this->bx[] = ['typ' => 'box', 'x' => 106.9, 'y' => 35, 'lx' => 93.1, 'ly' => 8, 'bcol' => 0];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 16, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 106.9, 'y' => 35, 'lx' => 93.1, 'ly' => 8, 'text' => 'Destinataire'];
    $this->tablabel['@destinat'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 14, 'style' => 'B', 'align' => 'L', 'color' => 0, 'x' => 106.9, 'y' => 45, 'lx' => 93.1, 'ly' => 6, 'text' => '@destinat'];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 14, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 106.9, 'y' => 51, 'lx' => 93.1, 'ly' => 6, 'text' => '@ad1'];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 14, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 106.9, 'y' => 57, 'lx' => 93.1, 'ly' => 6, 'text' => '@ad2'];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 14, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 106.9, 'y' => 63, 'lx' => 93.1, 'ly' => 6, 'text' => '@ad3'];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 14, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 106.9, 'y' => 69, 'lx' => 93.1, 'ly' => 6, 'text' => '@ad4'];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 14, 'style' => 'B', 'align' => 'L', 'color' => 0, 'x' => 10, 'y' => 80, 'lx' => 30, 'ly' => 6, 'text' => 'Date :'];
    $this->tablabel['@date'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 14, 'style' => 'B', 'align' => 'L', 'color' => 0, 'x' => 40, 'y' => 80, 'lx' => 50, 'ly' => 6, 'text' => '@date'];
    $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 93, 'lx' => 190, 'ly' => 120, 'bcol' => 0];
    $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 93, 'lx' => 130, 'ly' => 9, 'bcol' => 0];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 10, 'y' => 93, 'lx' => 130, 'ly' => 9, 'text' => 'Item'];
    $this->bx[] = ['typ' => 'box', 'x' => 140, 'y' => 93, 'lx' => 20, 'ly' => 9, 'bcol' => 0];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 140, 'y' => 93, 'lx' => 20, 'ly' => 9, 'text' => 'Prix HT'];
    $this->bx[] = ['typ' => 'box', 'x' => 160, 'y' => 93, 'lx' => 20, 'ly' => 9, 'bcol' => 0];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 160, 'y' => 93, 'lx' => 20, 'ly' => 9, 'text' => 'Taux TVA'];
    $this->bx[] = ['typ' => 'box', 'x' => 180, 'y' => 93, 'lx' => 20, 'ly' => 9, 'bcol' => 0];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 180, 'y' => 93, 'lx' => 20, 'ly' => 9, 'text' => 'Prix TTC'];
    $this->tablabel['@i1'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 102, 'lx' => 130, 'ly' => 9, 'text' => '@i1'];
    $this->tablabel['@h1'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 140, 'y' => 102, 'lx' => 20, 'ly' => 9, 'text' => '@h1'];
    $this->tablabel['@v1'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 160, 'y' => 102, 'lx' => 20, 'ly' => 9, 'text' => '@v1'];
    $this->tablabel['@t1'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 180, 'y' => 102, 'lx' => 20, 'ly' => 9, 'text' => '@t1'];
    $this->tablabel['@i2'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 111, 'lx' => 130, 'ly' => 9, 'text' => '@i2'];
    $this->tablabel['@h2'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 140, 'y' => 111, 'lx' => 20, 'ly' => 9, 'text' => '@h2'];
    $this->tablabel['@v2'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 160, 'y' => 111, 'lx' => 20, 'ly' => 9, 'text' => '@v2'];
    $this->tablabel['@t2'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 180, 'y' => 111, 'lx' => 20, 'ly' => 9, 'text' => '@t2'];
    $this->tablabel['@i3'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 120, 'lx' => 130, 'ly' => 9, 'text' => '@i3'];
    $this->tablabel['@h3'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 140, 'y' => 120, 'lx' => 20, 'ly' => 9, 'text' => '@h3'];
    $this->tablabel['@v3'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 160, 'y' => 120, 'lx' => 20, 'ly' => 9, 'text' => '@v3'];
    $this->tablabel['@t3'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 180, 'y' => 120, 'lx' => 20, 'ly' => 9, 'text' => '@t3'];
    $this->tablabel['@i4'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 129, 'lx' => 130, 'ly' => 9, 'text' => '@i4'];
    $this->tablabel['@h4'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 140, 'y' => 129, 'lx' => 20, 'ly' => 9, 'text' => '@h4'];
    $this->tablabel['@v4'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 160, 'y' => 129, 'lx' => 20, 'ly' => 9, 'text' => '@v4'];
    $this->tablabel['@t4'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 180, 'y' => 129, 'lx' => 20, 'ly' => 9, 'text' => '@t4'];
    $this->tablabel['@i5'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 138, 'lx' => 130, 'ly' => 9, 'text' => '@i5'];
    $this->tablabel['@h5'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 140, 'y' => 138, 'lx' => 20, 'ly' => 9, 'text' => '@h5'];
    $this->tablabel['@v5'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 160, 'y' => 138, 'lx' => 20, 'ly' => 9, 'text' => '@v5'];
    $this->tablabel['@t5'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 180, 'y' => 138, 'lx' => 20, 'ly' => 9, 'text' => '@t5'];
    $this->tablabel['@i6'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 147, 'lx' => 130, 'ly' => 9, 'text' => '@i6'];
    $this->tablabel['@h6'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 140, 'y' => 147, 'lx' => 20, 'ly' => 9, 'text' => '@h6'];
    $this->tablabel['@v6'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 160, 'y' => 147, 'lx' => 20, 'ly' => 9, 'text' => '@v6'];
    $this->tablabel['@t6'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 180, 'y' => 147, 'lx' => 20, 'ly' => 9, 'text' => '@t6'];
    $this->tablabel['@i7'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 156, 'lx' => 130, 'ly' => 9, 'text' => '@i7'];
    $this->tablabel['@h7'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 140, 'y' => 156, 'lx' => 20, 'ly' => 9, 'text' => '@h7'];
    $this->tablabel['@v7'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 160, 'y' => 156, 'lx' => 20, 'ly' => 9, 'text' => '@v7'];
    $this->tablabel['@t7'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 180, 'y' => 156, 'lx' => 20, 'ly' => 9, 'text' => '@t7'];
    $this->tablabel['@i8'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 165, 'lx' => 130, 'ly' => 9, 'text' => '@i8'];
    $this->tablabel['@h8'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 140, 'y' => 165, 'lx' => 20, 'ly' => 9, 'text' => '@h8'];
    $this->tablabel['@v8'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 160, 'y' => 165, 'lx' => 20, 'ly' => 9, 'text' => '@v8'];
    $this->tablabel['@t8'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 180, 'y' => 165, 'lx' => 20, 'ly' => 9, 'text' => '@t8'];
    $this->tablabel['@i9'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 174, 'lx' => 130, 'ly' => 9, 'text' => '@i9'];
    $this->tablabel['@h9'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 140, 'y' => 174, 'lx' => 20, 'ly' => 9, 'text' => '@h9'];
    $this->tablabel['@v9'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 160, 'y' => 174, 'lx' => 20, 'ly' => 9, 'text' => '@v9'];
    $this->tablabel['@t9'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 180, 'y' => 174, 'lx' => 20, 'ly' => 9, 'text' => '@t9'];
    $this->tablabel['@i10'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 183, 'lx' => 130, 'ly' => 9, 'text' => '@i10'];
    $this->tablabel['@h10'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 140, 'y' => 183, 'lx' => 20, 'ly' => 9, 'text' => '@h10'];
    $this->tablabel['@v10'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 160, 'y' => 183, 'lx' => 20, 'ly' => 9, 'text' => '@v10'];
    $this->tablabel['@t10'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 10, 'style' => '', 'align' => 'R', 'color' => 0, 'x' => 180, 'y' => 183, 'lx' => 20, 'ly' => 9, 'text' => '@t10'];
    $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 193, 'lx' => 152, 'ly' => 10, 'bcol' => 0];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 12, 'style' => 'B', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 193, 'lx' => 152, 'ly' => 10, 'text' => 'Total H.T'];
    $this->bx[] = ['typ' => 'box', 'x' => 162, 'y' => 193, 'lx' => 38, 'ly' => 10, 'bcol' => 0];
    $this->tablabel['@totht'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 12, 'style' => 'B', 'align' => 'R', 'color' => 0, 'x' => 162, 'y' => 193, 'lx' => 38, 'ly' => 10, 'text' => '@totht'];
    $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 203, 'lx' => 152, 'ly' => 10, 'bcol' => 0];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 12, 'style' => 'B', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 203, 'lx' => 152, 'ly' => 10, 'text' => 'Taxes'];
    $this->bx[] = ['typ' => 'box', 'x' => 162, 'y' => 203, 'lx' => 38, 'ly' => 10, 'bcol' => 0];
    $this->tablabel['@tottax'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 12, 'style' => 'B', 'align' => 'R', 'color' => 0, 'x' => 162, 'y' => 203, 'lx' => 38, 'ly' => 10, 'text' => '@tottax'];
    $this->bx[] = ['typ' => 'box', 'x' => 124, 'y' => 213, 'lx' => 38, 'ly' => 10, 'bcol' => 0];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 12, 'style' => 'B', 'align' => 'R', 'color' => 0, 'x' => 124, 'y' => 213, 'lx' => 38, 'ly' => 10, 'text' => 'Total TTC'];
    $this->bx[] = ['typ' => 'box', 'x' => 162, 'y' => 213, 'lx' => 38, 'ly' => 10, 'bcol' => 0];
    $this->tablabel['@totttc'] = false; // Non initialisé
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 12, 'style' => 'B', 'align' => 'R', 'color' => 0, 'x' => 162, 'y' => 213, 'lx' => 38, 'ly' => 10, 'text' => '@totttc'];
    $this->bx[] = ['typ' => 'box', 'x' => 10, 'y' => 249, 'lx' => 93.1, 'ly' => 30, 'bcol' => 0];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 10, 'y' => 249, 'lx' => 93.1, 'ly' => 6, 'text' => ' Grenoble Université Club - Section Plongée'];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 10, 'y' => 255, 'lx' => 93.1, 'ly' => 6, 'text' => ' Association loi 1901'];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 261, 'lx' => 41.895, 'ly' => 6, 'text' => 'SIRET:'];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 51.895, 'y' => 261, 'lx' => 51.205, 'ly' => 6, 'text' => '452 782 907 00029'];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 267, 'lx' => 41.895, 'ly' => 6, 'text' => 'Affiliation FFESSM:'];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 51.895, 'y' => 267, 'lx' => 51.205, 'ly' => 6, 'text' => '14 38 0024'];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => 'B', 'align' => 'R', 'color' => 0, 'x' => 10, 'y' => 273, 'lx' => 41.895, 'ly' => 6, 'text' => 'No d\'agréement J&S:'];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 9, 'style' => '', 'align' => 'L', 'color' => 0, 'x' => 51.895, 'y' => 273, 'lx' => 51.205, 'ly' => 6, 'text' => '38 06 016'];
    $this->bx[] = ['typ' => 'text', 'face' => 'comic', 'size' => 18, 'style' => 'B', 'align' => 'C', 'color' => 0, 'x' => 106.9, 'y' => 240, 'lx' => 93.1, 'ly' => 10, 'text' => 'Facture acquittée'];
    $this->bx[] = ['typ' => 'image', 'x' => 135.02, 'y' => 250.3, 'lx' => 148.96, 'ly' => 29.4, 'label' => '../pdf/tamponguc.gif'];
}
}
