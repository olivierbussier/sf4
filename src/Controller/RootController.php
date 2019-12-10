<?php

namespace App\Controller;

use App\Classes\Config\Config;
use App\Entity\Blog;
use App\Form\ContactType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RootController extends AbstractController
{
    /**
     * @Route("/", name="root")
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function index(ManagerRegistry $doctrine)
    {
        $posts = $doctrine->getRepository(Blog::class)->getallPosts();

        $dirImages = Config::blogImages;;

        return $this->render('pages/index.html.twig',[
			'imblog' => $dirImages,
            'posts' => $posts
		]);
    }

    /**
     * @Route("Bapteme", name="index_bapteme")
     */
    public function bapteme()
    {
        return $this->render('pages/index_bapteme.html.twig');
    }

    /**
     * @Route("calendrier", name="index_calendrier")
     */
    public function calendrier()
    {
        return $this->render('pages/index_calendrier.html.twig');
    }

    /**
     * @Route("contact", name="index_contact")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function contact(Request $request)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('index_contact_success',['toto' => 1]);
        }

        return $this->render('pages/index_contact.html.twig', [
            'formContact' => $form->createView()
        ]);
    }

    /**
     * @Route("contact_succes", name="index_contact_success")
     * @param Request $request
     * @return Response
     */
    public function contactSuccess(Request $request)
    {
        dump($request);
        return $this->render('pages/index_contact_success.html.twig');
    }
}
