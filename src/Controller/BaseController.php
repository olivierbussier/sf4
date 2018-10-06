<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Resultat;
use App\Form\ChoixCourseType;
use App\Form\EcrireType;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
     * @Route("/", name="root")
     * @param RegistryInterface $doctrine
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(RegistryInterface $doctrine)
    {
        $posts = $doctrine->getRepository(Blog::class)->getAllPosts();

        $conf = $this->getParameter('conf.blog');
        $dirImages = $conf['blog.images'];

        // affichage de toutes les images du rep pub

        $pubs = glob('public/imp/*.*');

        return $this->render(
            'pages/index.html.twig', [
                'imblog' => $dirImages,
                'posts' => $posts
        ]);
    }
    /**
     * @Route("/preview/{blogId}", name="root_preview")
     * @param RegistryInterface $doctrine
     * @param string $blogId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexPreviewBlog(RegistryInterface $doctrine, $blogId = '')
    {
        if ($blogId == '') {
            $this->redirectToRoute('root');
        }

        $post = $doctrine->getRepository(Blog::class)->find($blogId);

        $conf = $this->getParameter('conf.blog');
        $dirImages = $conf['blog.images'];

        return $this->render(
            'pages/index_preview.html.twig', [
            'post' => $post,
            'imblog' => $dirImages
        ]);
    }

    // Courses

    /**
     * @Route("/ecrire", name="ecrire")
     * @param Request $request
     * @param Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function ecrire(Request $request,Swift_Mailer $mailer)
    {
        $form = $this->createForm(EcrireType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();
            $message = (new Swift_Message('You Got Mail!'))
                ->setFrom($contactFormData['from'])
                ->setTo('contact@cross-biviers.fr')
                ->setBody(
                    $contactFormData['message'],
                    'text/plain'
                    )
            ;

            $res = $mailer->send($message);
            $this->addFlash('info', 'Message envoyé');
            return $this->redirectToRoute('ecrire');
        }

        return $this->render('pages/ecrire.html.twig',[
            'formEcrire' => $form->createView()
        ]);
    }
}
