<?php

namespace App\Repository;

use App\Entity\Diplome;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Diplome|null find($id, $lockMode = null, $lockVersion = null)
 * @method Diplome|null findOneBy(array $criteria, array $orderBy = null)
 * @method Diplome[]    findAll()
 * @method Diplome[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiplomeRepository extends ServiceEntityRepository
{
    public const DIP_TIV   =    'TIV';
    public const DIP_FTIV  =    'Formateur TIV';
    public const DIP_B1    =    'BEES1';
    public const DIP_B2    =    'BEES2';
    public const DIP_MF    =    'Médecin Fédéral';
    public const DIP_MA    =    'Médecin';
    public const DIP_PA    =    'PSE1/ANTEOR';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Diplome::class);
    }

    /**
     * @return Diplome[] Returns an array of Diplomes objects
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
     * @return Diplome[] Returns an array of Diplomes objects
     */

    public function getDiplomesSecourisme()
    {
        return $this->createQueryBuilder('d')
            ->leftJoin('d.user','a')
            ->addSelect('a')
            ->where("d.type = '".self::DIP_MF."' or d.type = '".self::DIP_MA."' or d.type = '".self::DIP_PA."'")
            ->orderBy('a.Nom', 'desc')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }
}
