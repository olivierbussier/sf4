<?php

namespace App\Controller\Intranet;

use App\Classes\Sheets\Sheets;
use App\Entity\Adherent;
use App\Form\InfoPersoType;
use App\Repository\AdherentRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IntranetController extends AbstractController
{
    /**
     * @Route("/intranet/index", name="index_intranet")
     * @param RegistryInterface $doctrine
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(RegistryInterface $doctrine)
    {
        $sheet = Sheets::getSheetURL();

        $user = $this->getUser();
        $adh = $doctrine->getRepository(Adherent::class)->find($user->getId());

        return $this->render('intranet/index.html.twig', [
            'adh' => $adh,
            'sheetBapteme' => $sheet
        ]);
    }

    /**
     * @Route("/intranet/trombi", name="index_trombi")
     * @param RegistryInterface $doctrine
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function trombi(RegistryInterface $doctrine)
    {
        $adhRepo = $doctrine->getRepository(Adherent::class);
        /** @var $adhRepo AdherentRepository */
        $photos = $adhRepo->getAllPhotos();

        return $this->render('intranet/index_trombi.html.twig',[
            'photos' => $photos
        ]);
    }

    /**
     * @Route("/intranet/index_admin_affiche_perso", name="index_admin_affiche_perso")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function affiche_perso(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(InfoPersoType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('');
        }

        return $this->render('intranet/index_affiche_perso.html.twig', [
            'formInfoPerso' => $form->createView(),
            'adh' => $user
        ]);
    }


}
