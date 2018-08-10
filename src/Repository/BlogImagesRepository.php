<?php

namespace App\Repository;

use App\Entity\BlogImages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BlogImages|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogImages|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogImages[]    findAll()
 * @method BlogImages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogImagesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BlogImages::class);
    }

//    /**
//     * @return BlogImages[] Returns an array of BlogImages objects
//     */
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
    public function findOneBySomeField($value): ?BlogImages
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
