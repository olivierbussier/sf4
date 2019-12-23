<?php

namespace App\Controller\Security;

use App\Classes\Form\FormConst;
use App\Entity\User;
use App\Entity\Role;
use App\Form\RegistrationType;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     * @param Request $request
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function Registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $user->setInscrType(FormConst::REGISTER);

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            // Doits par défaut

            //$user->setRoles('ROLE_USER');

            $user->setCodeSecret('');
            $user->setDateNaissance(new DateTime('now'));
            $user->setNiveauSca('');
            $user->setNiveauApn('');
            $user->addRole((new Role())->setRole('ROLE_USER'));

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('connexion');
        }

        return $this->render('intranet/registration.html.twig', [
            'formInscr' => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion", name="connexion")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastuser = $authenticationUtils->getLastUsername();

        return $this->render('intranet/login.html.twig',[
            'error'     => $error,
            'lastUser'  => $lastuser
        ]);
    }

    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function logout()
    {
    }
}
