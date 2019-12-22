<?php

namespace App\Controller\Intranet\Admin;

use App\Classes\Form\FormConst;
use App\Entity\Adherent;
use App\Entity\FilterDroits;
use App\Entity\Role;
use App\Form\FilterDroitsType;
use App\Repository\AdherentRepository;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexAdminController extends AbstractController
{
    /**
     * @Route("/intranet/admin_export_trombi", name="admin_export_trombi")
     */
    public function adminExportTrombi()
    {
        return $this->render('');
    }

    private function encodeResponse($response)
    {
        return new Response(json_encode($response));
    }

    /**
     * @Route("/intranet/admin/ajax_droits", name="ajax_droits")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function ajaxDroits(EntityManagerInterface $em, Request $request) : Response
    {
        $id = $request->get('id');
        $value = $request->get('value');

        $v = explode('-', $id);

        if (count($v) < 3 || $v[0] != 'ck') {
            return $this->encodeResponse([]);
        }

        $userId = $v[1];
        $role   = $v[2];

        if (!is_numeric($userId)) {
            return $this->encodeResponse([]);
        }
        // Recherche du droit concerné dans la base

        /** @var AdherentRepository $adh */
        $adh = $em->getRepository(Adherent::class);
        $user = $adh->find($userId);


        switch ($value) {
            case 'true':
                foreach ($user->getRolesAsObjects() as $v) {
                    if ($v->getRole() == $role) {
                        // Le role existe déjà
                        return $this->encodeResponse([]);
                    }
                }
                $r = (new Role())->setRole($role);
                $user->addRole($r);
                $em->persist($r);
                break;
            case 'false':
                foreach ($user->getRolesAsObjects() as $v) {
                    if ($v->getRole() == $role) {
                        $user->removeRole($v);
                        $em->remove($v);
                    }
                }
                break;
        }
        //$em->persist($user);
        $em->flush();

        return $this->encodeResponse([
            'id' => $id,
            'newState' => $value
        ]);
    }

    /**
     * @Route("/intranet/admin/admin_droits_utilisateur", name="admin_droits")
     * @param EntityManagerInterface $em
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function adminDroits(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {
        $search = new FilterDroits();
        $form = $this->createForm(FilterDroitsType::class, $search);
        $form->handleRequest($request);

        /** @var AdherentRepository $ar */
        $ar = $em->getRepository(Adherent::class);
        $query = $ar->getAdherentsRights($search);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            15 /*limit per page*/
        );
        return $this->render('intranet/admin/admin_droits.html.twig', [
            'pagination' => $pagination,
            'roles' => FormConst::LISTE_ROLES,
            'abbr_roles' => FormConst::ABBREV_ROLES,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/intranet/admin_gen_excel/full", name="admin_gen_excel_full")
     */
    public function adminGenExcelFull()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/admin_gen_excel/inscrits", name="admin_gen_excel_inscrits")
     */
    public function adminGenExcelInscrits()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/admin_info_server/php", name="admin_info_server_php")
     */
    public function adminInfoPHP()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/admin_info_server/mysql", name="admin_info_server_mysql")
     */
    public function adminInfoMySQL()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/admin_log/mysql", name="admin_log_mysql")
     */
    public function adminLogMysql()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/admin_log/reset_log_mysql", name="admin_reset_log_mysql")
     */
    public function adminResetLogMysql()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/admin_log/mail", name="admin_log_mail")
     */
    public function adminLogMail()
    {
        return $this->render('');
    }

    /**
     * @Route("/intranet/admin_log/intranet", name="admin_log_intranet")
     */
    public function adminResetLogMyssql()
    {
        return $this->render('');
    }
}
