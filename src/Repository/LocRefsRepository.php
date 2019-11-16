<?php

namespace App\Repository;

use App\Entity\LocRefs;
use DateTime;
use DateTimeZone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Exception;

/**
 * @method LocRefs|null find($id, $lockMode = null, $lockVersion = null)
 * @method LocRefs|null findOneBy(array $criteria, array $orderBy = null)
 * @method LocRefs[]    findAll()
 * @method LocRefs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocRefsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LocRefs::class);
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function getRefResa()
    {
        $locref = new LocRefs();
        $locref->setCreatedAt(new DateTime("now",  new DateTimeZone('Europe/Paris')));
        $em = $this->getEntityManager();
        $em->persist($locref);
        $em->flush();
        return $locref->getId();
    }

    // /**
    //  * @return LocRefs[] Returns an array of LocRefs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LocRefs
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
