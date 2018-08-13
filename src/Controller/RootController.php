<?php

namespace App\Controller;

use App\Entity\Blog;
use Symfony\Bridge\Doctrine\RegistryInterface;
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
        return $this->render(
            'pages/index.html.twig',
            ['posts' => $posts]);
    }

    /**
     * @Route("Bapteme", name="index_bapteme")
     */
    public function bapteme()
    {
        return $this->render('pages/bapteme.html.twig');
    }

    /**
     * @Route("calendrier", name="index_calendrier")
     */
    public function calendrier()
    {
        return $this->render('pages/calendrier.html.twig');
    }

    /**
     * @Route("contact", name="index_contact")
     */
    public function contact()
    {
        return $this->render('pages/contact.html.twig');
    }
}
