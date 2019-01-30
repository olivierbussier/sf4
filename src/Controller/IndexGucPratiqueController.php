<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexGucPratiqueController extends AbstractController
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
