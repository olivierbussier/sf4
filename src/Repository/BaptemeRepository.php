<?php

namespace App\Repository;

use App\Entity\Bapteme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Bapteme|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bapteme|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bapteme[]    findAll()
 * @method Bapteme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BaptemeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bapteme::class);
    }

    // /**
    //  * @return Bapteme[] Returns an array of Bapteme objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bapteme
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
