<?php

namespace App\Repository;

use App\Entity\Calendrier;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Calendrier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Calendrier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Calendrier[]    findAll()
 * @method Calendrier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalendrierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Calendrier::class);
    }

    /**
     * @param DateTime $afterDate
     * @return Calendrier[] Returns an array of Calendrier objects
     */
    public function findDatesAfter(DateTime $afterDate, array $criterias)
    {
        $query = $this->createQueryBuilder('c')
            ->where('c.archive = false')
            ->andWhere("c.date >= '" . $afterDate->format('Y-m-d') . "'")
            ->orderBy('c.date', 'ASC');

        foreach ($criterias as $k => $v) {
            $query->andWhere("c.$k = '$v'");
        }
        return $query->getQuery()
                     ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Calendrier
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
