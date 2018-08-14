<?php

namespace App\Controller\Intranet;

use App\Entity\Adherent;
use App\Repository\AdherentRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexBaptemeController extends Controller
{
    /**
     * @Route("/intranet/bapteme", name="index_bapteme")
     */
    public function index(RegistryInterface $doctrine)
    {
        $user = $this->getUser();
        $adh = $doctrine->getRepository(Adherent::class)->find($user->getId());
        return $this->render('intranet/index.html.twig', [
            'adh' => $adh
        ]);
    }
}
