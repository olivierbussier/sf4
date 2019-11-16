<?php

namespace App\Repository;

use App\Entity\MatCarac;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MatCarac|null find($id, $lockMode = null, $lockVersion = null)
 * @method MatCarac|null findOneBy(array $criteria, array $orderBy = null)
 * @method MatCarac[]    findAll()
 * @method MatCarac[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatCaracRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MatCarac::class);
    }


    /**
     * Retourne la liste des types d'assets
     */
    public function getDistinctTypes()
    {
        return $this->createQueryBuilder('types')
            ->select("types.AssetType")
            ->distinct()
            ->getQuery()
            ->execute();

        // $res = $db->query("select distinct AssetType from @#@loc_matcarac");
    }
    // /**
    //  * @return MatCarac[] Returns an array of MatCarac objects
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
    public function findOneBySomeField($value): ?MatCarac
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
