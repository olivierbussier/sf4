<?php

namespace App\Controller\Intranet;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexAdminPublicationController extends Controller
{
    /**
     * @Route("/admin/publication/blog", name="admin_blog")
     */
    public function adminBlog()
    {
        return $this->render('intranet/menu/index_admin_publication.html.twig');
    }

    /**
     * @Route("/admin/publication/diplomes", name="admin_diplomes")
     */
    public function adminDiplomes()
    {
        return $this->render('intranet/menu/index_admin_diplomes.html.twig');
    }
}
