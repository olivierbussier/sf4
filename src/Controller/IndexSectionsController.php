<?php

namespace App\Controller;

use App\Entity\Diplome;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexSectionsController extends Controller
{
    /**
     * @Route("/index_formation_enfants", name="index_formation_enfants")
     */
    public function enfants()
    {
        return $this->render('pages/index_formation_enfants.html.twig');
    }

    /**
     * @Route("/index_formation_initiateur", name="index_formation_initiateur")
     */
    public function initiateur()
    {
        return $this->render('pages/index_formation_initiateur.html.twig');
    }

    /**
     * @Route("/index_formation_n1", name="index_formation_n1")
     */
    public function N1()
    {
        return $this->render('pages/index_formation_N1.html.twig');
    }

    /**
     * @Route("/index_formation_n2", name="index_formation_n2")
     */
    public function N2()
    {
        return $this->render('pages/index_formation_N2.html.twig');
    }

    /**
     * @Route("/index_formation_n3n4", name="index_formation_n3n4")
     */
    public function N3N4()
    {
        return $this->render('pages/index_formation_N3N4.html.twig');
    }

    /**
     * @Route("/index_formation_secourisme", name="index_formation_secourisme")
     */
    public function Secourisme(RegistryInterface $doctrine)
    {
        // Recherche des diplomes

        $Diplomes = $doctrine->getRepository(Diplome::class)->getDiplomesSecourisme();

        return $this->render(
            'pages/index_formation_secourisme.html.twig',
            ['Diplomes' => $Diplomes]);
    }
}
