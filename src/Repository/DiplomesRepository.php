<?php

namespace App\Repository;

use App\Entity\Diplomes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Diplomes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Diplomes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Diplomes[]    findAll()
 * @method Diplomes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiplomesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Diplomes::class);
    }

    /**
     * @return Diplomes[] Returns an array of Diplomes objects
     */

    public function getAllDiplomes()
    {
        return $this->createQueryBuilder('d')
            ->leftJoin('d.User','a')
            ->addSelect('a')
            ->orderBy('a.Nom', 'desc')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Diplomes[] Returns an array of Diplomes objects
     */

    public function getDiplomesSecourisme()
    {
        return $this->createQueryBuilder('d')
            ->leftJoin('d.User','a')
            ->addSelect('a')
            ->where("d.Type = 'MF' or d.Type = 'MA' or d.Type = 'PA'")
            ->orderBy('a.Nom', 'desc')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

//    /**
//     * @return Diplomes[] Returns an array of Diplomes objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Diplomes
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
