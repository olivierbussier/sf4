<?php

namespace App\Controller\Intranet;

use App\Classes\Sheets\Sheets;
use App\Entity\Adherent;
use App\Form\InfoPersoType;
use App\Repository\AdherentRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IntranetController extends AbstractController
{
    /**
     * @Route("/intranet", name="index_intranet")
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function index(ManagerRegistry $doctrine)
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
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function trombi(ManagerRegistry $doctrine)
    {
        $adhRepo = $doctrine->getRepository(Adherent::class);
        /** @var $adhRepo AdherentRepository */
        $photos = $adhRepo->getAllPhotos();

        return $this->render('intranet/index_trombi.html.twig',[
            'photos' => $photos
        ]);
    }

    /**
     * @Route("/intranet/info_perso", name="index_admin_affiche_perso")
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function affiche_info_perso(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(InfoPersoType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            // Vérif si le mail a changé

            return $this->redirectToRoute('');
        }

        return $this->render('intranet/index_affiche_perso.html.twig', [
            'formInfoPerso' => $form->createView(),
            'adh' => $user
        ]);
    }
}
