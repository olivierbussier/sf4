<?php

namespace App\Repository;

use App\Entity\Adherent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Adherent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Adherent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Adherent[]    findAll()
 * @method Adherent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdherentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
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
            ->where("JSON_EXTRACT(a.AdminOK,'$.VALID') = true")
            ->getQuery()
            ->getResult()
        ;
    }
}
