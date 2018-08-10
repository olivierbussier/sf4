<?php

namespace App\Controller;

use App\Entity\Diplomes;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexFormationSecourismeController extends Controller
{
    /**
     * @Route("/index_formation_secourisme", name="index_formation_secourisme")
     */
    public function index(RegistryInterface $doctrine)
    {
        // Recherche des diplomes

        $Diplomes = $doctrine->getRepository(Diplomes::class)->getallDiplomes();

        return $this->render(
            'pages/index_formation_secourisme.html.twig',
            ['Diplomes' => $Diplomes]);
    }
}
