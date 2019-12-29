<?php

namespace App\Controller;

use App\Entity\Diplome;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexSectionsController extends AbstractController
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
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function Secourisme(EntityManagerInterface $em)
    {
        // Recherche des diplomes

        $rpDipl = $em->getRepository(Diplome::class);
        $Diplomes = $rpDipl->getDiplomesSecourisme();

        return $this->render(
            'pages/index_formation_secourisme.html.twig',
            ['Diplomes' => $Diplomes]);
    }
}
