<?php

namespace App\Controller;

use App\Classes\Config\Config;
use App\Entity\Blog;
use App\Form\EcrireType;
use Doctrine\ORM\EntityManagerInterface;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{

    /**
     * @Route("/preview/{blogId}", name="root_preview")
     * @param EntityManagerInterface $em
     * @param string $blogId
     * @return Response
     */
    public function indexPreviewBlog(EntityManagerInterface $em, $blogId = '')
    {
        if ($blogId == '') {
            $this->redirectToRoute('root');
        }

        $post = $em->getRepository(Blog::class)->find($blogId);

        $dirImages = Config::blogImages;

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
     * @return RedirectResponse|Response
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
