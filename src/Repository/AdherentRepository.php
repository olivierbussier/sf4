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
       /* $tr =  $this->createQueryBuilder('d')
            ->leftJoin('d.User','a')
            ->addSelect('a')
            ->leftJoin('d.UserParams','u')
            ->addSelect('u')
            ->where("d.Type = 'MF' or d.Type = 'MA' or d.Type = 'PA'")
            ->orderBy('a.Nom', 'desc')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
*/
        return $this->createQueryBuilder('a')
            ->leftJoin('a.UserParams','d')
            ->addSelect('d')
            ->andWhere("d.AdminOK = 'OK'")
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Adherents
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
