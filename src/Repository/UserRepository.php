<?php

namespace App\Repository;

use App\Classes\Form\FormConst;
use App\Entity\User;
use App\Entity\FilterDroits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;


/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return User[] Returns an array of User objects
     */

    public function getAllPhotos()
    {
        return $this->createQueryBuilder('a')
            ->select(['a.nom','a.prenom','a.fTrombi','a.NiveauSca','a.id'])
            ->orderBy('a.nom','asc')
            ->where("a.AdminOK <> ''")
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne la query permettant de lister les droits des utilisateurs ciblés par $search
     * Si $search est vide, retourne la query des utilisateurs disposant de droits autres que ROLE_USER
     *
     * @param FilterDroits $search
     * @return Query
     */
    public function getUserssRights(FilterDroits $search)
    {

        $query = $this->createQueryBuilder('a')
            ->select('a')
            //->andWhere('a.id = 410 or a.id = 10')
            ->orderBy('a.Nom, a.Prenom');

        if ($s = $search->getSearch()) {
            if (in_array(strtoupper($s), FormConst::ABBREV_ROLES)) {
                $query->join("a.roles","r")
                ->where("r.role like '%".strtoupper($s)."%'");
            } else {
                $query->where("a.Nom like '%$s%'");
            }
        } else {
            $query->where('SIZE(a.roles) > 1');
        }
        return $query->getQuery();


    }
}
