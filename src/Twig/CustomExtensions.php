<?php

namespace App\Twig;

use App\Classes\Config\Config;
use App\Classes\Helpers\FileHelper;
use App\Entity\User;
use Symfony\Bridge\Twig\AppVariable;
use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CustomExtensions extends AbstractExtension
{
    private $pd;

    public function __construct(KernelInterface $ki)
    {
        $this->pd = $ki->getProjectDir() . '/public';
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('readfile'           , [$this, 'readFile']),
            new TwigFunction('fileExists'         , [$this, 'fileExists']),
            new TwigFunction('rationalizeFilename', [$this, 'rationalizeFilename']),
            new TwigFunction('testDroit'          , [$this, 'testDroit']),
            new TwigFunction('conf'               , [$this, 'getConf'])
        ];
    }

    public function getConf($conf,$class = "App\\Classes\\Config\\Config")
    {
        $cdef = defined("$class::$conf");

        if ($cdef) {
            $res = constant("App\\Classes\\Config\\Config::$conf");
        } else {
            $res = Config::$$conf;
        }
        return $res;
    }

    public function readFile(string $filename)
    {
        return file_get_contents('./' . $filename);
    }

    public function fileExists(string $filename)
    {
        return file_exists($filename) || file_exists($this->pd . $filename);
    }

    public function rationalizeFilename($file)
    {
        // Convert spaces, caracteres accentués  to '_'

        $retfile = str_replace(' ','_',$file);
        //$retfile = str_replace('-','_',$retfile);

        return $retfile;
    }

    /**
     * @param AppVariable $app
     * @param $droit
     * @return bool
     */
    public function testDroit(AppVariable $app, $droit)
    {
        /** @var User $cx */
        $cx = $app->getUser();
        if ($cx) {
            $roles = $cx->getRoles();
            foreach ($roles as $v) {
                if ($v == 'ROLE_ADMIN') {
                    return true;
                }
                if ($v == $droit) {
                    return true;
                }
            }
            return false;
        } else {
            return false;
        }
    }
}
