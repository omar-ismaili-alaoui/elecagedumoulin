<?php

namespace App\Repository;

use App\Entity\RaceGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RaceGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method RaceGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method RaceGroup[]    findAll()
 * @method RaceGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RaceGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RaceGroup::class);
    }

    // /**
    //  * @return RaceGroup[] Returns an array of RaceGroup objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RaceGroup
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
