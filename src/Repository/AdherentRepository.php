<?php

namespace App\Repository;

use App\Classes\Form\FormConst;
use App\Entity\Adherent;
use App\Entity\FilterDroits;
use App\Entity\Role;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;


/**
 * @method Adherent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Adherent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Adherent[]    findAll()
 * @method Adherent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdherentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adherent::class);
    }

    /**
     * @return Adherent[] Returns an array of Adherents objects
     */

    public function getAllPhotos()
    {
        return $this->createQueryBuilder('a')
            ->select(['a.Nom','a.Prenom','a.fTrombi','a.NiveauSca','a.id'])
            ->orderBy('a.Nom','asc')
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
    public function getAdherentsRights(FilterDroits $search)
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
