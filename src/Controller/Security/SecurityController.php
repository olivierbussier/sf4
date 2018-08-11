<?php

namespace App\Controller\Security;

use App\Entity\Adherent;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/inscription", name="inscription")
     */
    public function Registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new Adherent();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            // Doits par défaut

            $user->setRoles('ROLE_USER');

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('connexion');
        }

        return $this->render('intranet/inscription.html.twig', [
            'formInscr' => $form->createView()
        ]);
    }
    /**
     * @Route("/connexion", name="connexion")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {

        return $this->render('intranet/login.html.twig');
    }
    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function logout()
    {
    }
}