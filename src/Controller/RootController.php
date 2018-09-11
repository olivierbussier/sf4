<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\ContactType;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RootController extends Controller
{
    /**
     * @Route("/", name="root")
     * @throws \ReflectionException
     */
    public function index(RegistryInterface $doctrine)
    {
        $posts = $doctrine->getRepository(Blog::class)->getallPosts();

        $conf = $this->getParameter('conf.blog');
        $dirImages = $conf['blog.images'];

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
     */
    public function contactSuccess(Request $request)
    {
        dump($request);
        return $this->render('pages/index_contact_success.html.twig');
    }
}
