<?php

namespace App\Controller\Intranet;

use App\Classes\Helpers\FileHelper;
use App\Classes\Sheets\Sheets;
use App\Entity\User;
use App\Form\InfoPersoType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IntranetController extends AbstractController
{
    /**
     * @Route("/intranet", name="index_intranet")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function index(EntityManagerInterface $em)
    {
        $sheet = Sheets::getSheetURL();

        $user = $this->getUser();
        $adh = $em->getRepository(User::class)->find($user->getId());

        return $this->render('intranet/index.html.twig', [
            'adh' => $adh,
            'sheetBapteme' => $sheet
        ]);
    }

    /**
     * @Route("/intranet/trombi", name="index_trombi")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function trombi(EntityManagerInterface $em)
    {
        $adhRepo = $em->getRepository(User::class);
        /** @var $adhRepo UserRepository */
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
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(InfoPersoType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            // Vérif si le mail a changé

            return $this->redirectToRoute('');
        }

        $tabFiles = FileHelper::getFiles('CERTIF', $user->getNom(), $user->getPrenom(), $user->getId());

        return $this->render('intranet/index_affiche_perso.html.twig', [
            'formInfoPerso' => $form->createView(),
            'files' => $tabFiles,
            'adh' => $user
        ]);
    }
}
