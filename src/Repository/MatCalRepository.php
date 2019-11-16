<?php

namespace App\Repository;

use App\Entity\MatCal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MatCal|null find($id, $lockMode = null, $lockVersion = null)
 * @method MatCal|null findOneBy(array $criteria, array $orderBy = null)
 * @method MatCal[]    findAll()
 * @method MatCal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatCalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MatCal::class);
    }

    // /**
    //  * @return MatCal[] Returns an array of MatCal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MatCal
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
