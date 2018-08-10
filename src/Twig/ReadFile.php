<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig_Function;

class ReadFile extends AbstractExtension
{
    public function getFunctions()
    {
        return array(
            new Twig_Function('readfile', array($this, 'readFile')),
        );
    }

    public function readFile(string $filename)
    {
        return file_get_contents('./' . $filename);
    }
}