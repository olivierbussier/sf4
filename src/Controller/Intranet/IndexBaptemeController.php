<?php

namespace App\Controller\Intranet;

use App\Entity\Adherent;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexBaptemeController extends AbstractController
{
    /**
     * @Route("/intranet/bapteme", name="index_bapteme")
     * @param RegistryInterface $doctrine
     * @return \Symfony\Component\HttpFoundation\Response
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
