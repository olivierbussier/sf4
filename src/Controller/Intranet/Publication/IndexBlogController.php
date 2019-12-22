<?php

namespace App\Controller\Intranet\Publication;

use App\Classes\Blog\BlogHelpers;
use App\Classes\Config\Config;
use App\Entity\Blog;
use App\Form\BlogEditType;
use App\Repository\BlogRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class IndexBlogController extends AbstractController
{
    /**
     * @Route("/intranet/publication", name="blog_admin_index")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        /**
         * @var $blogsRepo BlogRepository
         */
        $blogsRepo = $em->getRepository(Blog::class);

        // Afficher les blogs

        $blogs     = $blogsRepo->getAllPosts();

        return $this->render('intranet/blog_index.html.twig',[
            'blogs' => $blogs,
        ]);
    }

    /**
     * @Route("/intranet/publication/admin_blog/delete/{blogId}", name="blog_admin_delete")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param string $blogId
     * @return Response
     */
    public function delete(EntityManagerInterface $em, Request $request, $blogId = ''):Response
    {
        /**
         * @var $blogsRepo BlogRepository
         */
        $blogsRepo = $em->getRepository(Blog::class);

        if (!$blogsRepo->deleteById($blogId)) {
            throw $this->createNotFoundException(
                "Blog non trouvé : ID = " . $blogId
            );
        }

        // Afficher les blogs

        $blogs     = $blogsRepo->getAllPosts();

        return $this->render('intranet/blog_index.html.twig',[
            'blogs' => $blogs,
        ]);
    }

    /**
     * @Route("/intranet/publication/admin_blog/up/{blogId}", name="blog_admin_up")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param string $blogId
     * @return Response
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function up(EntityManagerInterface $em, Request $request, $blogId = '')
    {
        /**
         * @var $blogsRepo BlogRepository
         */
        $blogsRepo = $em->getRepository(Blog::class);

        $blogSrc = $blogsRepo->find($blogId);
        $positionSrc = $blogSrc->getPosition();

        $positionDest = $blogsRepo->selectPosJustBelow($positionSrc);

        $blogDest = $blogsRepo->selectByPosition($positionDest);

        $blogSrc->setPosition($positionDest);
        $blogDest->setPosition($positionSrc);
        $em->persist($blogDest);
        $em->persist($blogSrc);
        $em->flush();

        // Afficher les blogs

        $blogs     = $blogsRepo->getAllPosts();

        return $this->render('intranet/blog_index.html.twig',[
            'blogs' => $blogs,
        ]);
    }

    /**
     * @Route("/intranet/publication/admin_blog/down/{blogId}", name="blog_admin_down")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param string $blogId
     * @return Response
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function down(EntityManagerInterface $em, Request $request, $blogId = '')
    {
        /**
         * @var $blogsRepo BlogRepository
         */
        $blogsRepo = $em->getRepository(Blog::class);

        $blogSrc = $blogsRepo->find($blogId);
        $positionSrc = $blogSrc->getPosition();

        $positionDest = $blogsRepo->selectPosJustAbove($positionSrc);

        $blogDest = $blogsRepo->selectByPosition($positionDest);

        $blogSrc->setPosition($positionDest);
        $blogDest->setPosition($positionSrc);
        $em->persist($blogDest);
        $em->persist($blogSrc);
        $em->flush();

        // Afficher les blogs

        $blogs     = $blogsRepo->getAllPosts();

        return $this->render('intranet/blog_index.html.twig',[
            'blogs' => $blogs,
        ]);
    }

    /**
     * @Route("/intranet/publication/admin_blog/new", name="blog_admin_create")
     * @Route("/intranet/publication/admin_blog/edit/{blogId}", name="blog_admin_edit")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param int $blogId
     * @return Response
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function create(EntityManagerInterface $em, Request $request, $blogId=0)
    {
        /**
         * @var $blogsRepo BlogRepository
         */
        $blogsRepo = $em->getRepository(Blog::class);

        $dirImages = Config::blogImages;;

        if ($blogId == 0) {
            $blog = new Blog();
        } else {
            $blog = $blogsRepo->find($blogId);
        }

        $form = $this->createForm(BlogEditType::class, $blog);

        $form->handleRequest($request);

        $orient = '';
        $im = $blog->getImage();

        if ($form->isSubmitted() && $form->isValid()) {

            if ($blog->getId() == null) {
                // Nouveau, remplir postedAt et Position

                // Set Position

                $pos = $blogsRepo->selectPosJustAbove(999999999);
                $blog->setPosition($pos + 1);

                // Set Date

                $blog->setPostedAt(new DateTime());
            }

            $fl = $blog->getFile();

            if ($fl != null) {

                $oldImage = null;

                if ($im != null) {
                    // Une image existe déjà et une nouvelle est choisie
                    // Mémorisation pour suppression
                    $oldImage = $im;
                }

                // Gestion de l'image
                // Si création, pas besoin de tester si une ancienne image est à effacer

                // Mise à l'échelle de la photo:
                //  - Si l'image est sur toute la largeur, alors on réduit a 1200px en largeur
                //  - Si l'image est a gauche ou a droite, alors on réduit a 400px en largeur

                /**
                 * @var UploadedFile $image
                 */
                $image = $form['file']->getData();

                $info = getimagesize($image->getPathname());

                if ($info[0] > $info[1]) {
                    $orient = 'paysage';
                } else {
                    $orient = 'portrait';
                }
                switch ($blog->getPositionImage()) {
                    case 'dessus':
                    case 'dessous':
                        $largeur = 1400;
                        break;
                    case 'gauche':
                    case 'droite':
                        $largeur = 400;
                        break;
                    default:
                        $largeur = 400;
                        break;
                }
                $im = BlogHelpers::StorePhoto($image->getPathname(), $dirImages, $largeur);

                if ($oldImage) {
                    unlink("$dirImages/$oldImage");
                }
                $blog->setImage($im);
            }
            $em->persist($blog);
            $em->flush();
        }

        return $this->render('intranet/blog_edit.html.twig',[
            'formBlogEdit' => $form->createView(),
            'orient' => $orient,
            'image'  => $im,
            'id'     => $blogId,
            'imblog' => $dirImages
        ]);
    }

    /**
     * @Route("intranet/publication/admin_blog/delete_image/{blogId}", name="blog_admin_delete_image")
     * @param EntityManagerInterface $em
     * @param int $blogId
     * @return RedirectResponse
     */
    public function deleteImage(EntityManagerInterface $em, $blogId = 0)
    {
        if ($blogId == 0) {
            $this->redirectToRoute('root');
        }

        $dirImages = Config::blogImages;;
        /**
         * @var $blogsRepo BlogRepository
         */
        $em = $this->getDoctrine()->getManager();
        $blogsRepo = $em->getRepository(Blog::class);
        $blog = $blogsRepo->find($blogId);

        $image = $blog->getImage();

        if ($image) {
            // Une image existe
            unlink("$dirImages/$image");
            $blog->setImage(null);
            $em->persist($blog);
            $em->flush();
        }
        return $this->redirectToRoute("blog_admin_edit",['blogId' => $blogId]);
    }
}
