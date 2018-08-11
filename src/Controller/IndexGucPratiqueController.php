<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexGucPratiqueController extends Controller
{
    /**
     * @Route("/index_documents", name="index_documents")
     */
    public function documents()
    {
        return $this->render('pages/index_documents.html.twig');
    }

    /**
     * @Route("/index_liens", name="index_liens")
     */
    public function liens()
    {
        return $this->render('pages/index_liens.html.twig');
    }
}
