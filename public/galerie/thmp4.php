<?php

use App\Galerie\GalConfig;

require __DIR__ . '/../../vendor/autoload.php';

error_reporting(E_ALL);

$TEST = false;

function exec_ffmpeg()
{
    global $TEST;

    if ($TEST) {
        return "echo";
    }

    if (php_uname('s') == 'Windows NT') {
        return 'ffmpeg.exe';
    }
    if (php_uname('s') == 'Linux') {
        return './ffmpeg';
    }
}

function videoToMP4($psrc)
{
    $divers  = "-hide_banner";
    $execmd = exec_ffmpeg();

    $fileDir  = pathinfo($psrc, PATHINFO_DIRNAME);
    $fileBase = pathinfo($psrc, PATHINFO_FILENAME);

    $lcmd = "$execmd $divers -i \"$psrc\" \"$fileDir/$fileBase.mp4\"";
    echo "\n\n****************************************************************\n".
             $lcmd."\n".
             "****************************************************************\n\n";
    $ret2 = exec($lcmd, $out, $ret);

    return $ret;
}

function videoToGif($psrc, $pthb)
{
    global $thbMaxHeight;

    $hThumb  = $thbMaxHeight / (16/9);
    $qdiv    = 100;  // Temps vid divisé par 10, et 1 image toutes les 10 secondes
    $rate    = $qdiv/25;
    $pts     = 1/$qdiv;
    $palette = "palette.png";
    $accel   = ""; //"-hwaccel auto";
    $filters = "setpts=$pts*PTS , scale=h=$hThumb:w=-1";
    $fr      = "-r $rate";
    //$filters = "setpts=0.02*PTS , scale=h=$hThumb:w=-1";
    $divers  = "-hide_banner";

    $execmd = exec_ffmpeg();

    $lcmd = "$execmd $accel $divers -i \"$psrc\" $fr -vf \"$filters,palettegen\" -y $palette";
    echo "\n\n****************************************************************\n".
             $lcmd."\n".
             "****************************************************************\n\n";
    echo shell_exec($lcmd);

    $lcmd = "$execmd $accel $divers -i \"$psrc\" -i $palette $fr ".
              "-lavfi \"$filters [x]; [x][1:v] paletteuse=dither=sierra2\" -y \"$pthb\"";
    echo "\n\n****************************************************************\n".
             $lcmd."\n".
             "****************************************************************\n\n";
    echo shell_exec($lcmd);
}

$gengif = true;

foreach ($argv as $key => $value) {
    if ($value == 'convertonly') {
        $gengif  = false;
    }
}
// Enumération des fichiers dans les répertoires

$repSrc = 'img';
$repThb = 'thumb';

$dirs = GalConfig::getDir($repSrc);

foreach ($dirs as $k => $v) {
    echo "'$v' :\n";
    //$v = iconv("ANSI", "WINDOWS-1252//TRANSLIT", $v);
    $list = GalConfig::getVidFiles($v);

    foreach ($list as $v) {
        //echo "   - '".$v."' :\n";
        //$v = iconv("ISO-8859-1", "WINDOWS-1252//TRANSLIT", $v);
        $name = substr($v, strlen($repSrc)+1);

        $fileBase = pathinfo($name, PATHINFO_FILENAME);
        $fileExt  = pathinfo($name, PATHINFO_EXTENSION);
        $fileDir  = pathinfo($name, PATHINFO_DIRNAME);

        $psrc = $repSrc.'/'.$fileDir.'/'.$fileBase.'.'.$fileExt;
        $pthb = $repThb.'/'.$fileDir.'/'.$fileBase.'.gif';

        switch ($fileExt) {
            case 'avi':
            case 'mpg':
            case 'mpeg':
            case 'mkv':
            case 'wmv':
            case 'mov':
            case 'm4v':
            case 'flv':
                // Phase de conversion
                echo " - fichier $psrc = A convertir\n";
                $res = videoToMP4($psrc);
                if ($res != 0) {
                    break;
                }
                unlink($psrc);
                $psrc = $repSrc.'/'.$fileDir.'/'.$fileBase.'.mp4';
                // On enchaine sur la generation de la vignette
            case 'mp4':
                // On vérifie si le thumb existe ?
                if (!file_exists($pthb) && $gengif) {
                    echo " - fichier $pthb = A créer\n";
                    // Vérif si le rep thumbnail existe
                    if (!file_exists($repThb.'/'.$fileDir)) {
                        mkdir($repThb.'/'.$fileDir);
                        echo " - Répertoire '$repThb/$fileDir' = Créé\n";
                    }
                    videoToGif($psrc, $pthb);
                } else {
                    echo " - fichier $psrc = OK\n";
                }
                break;
        }
    }
}
