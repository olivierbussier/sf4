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
}
