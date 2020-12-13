<?php

namespace App\Repository;

use App\Entity\BdgAnnonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BdgAnnonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method BdgAnnonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method BdgAnnonce[]    findAll()
 * @method BdgAnnonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BdgAnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BdgAnnonce::class);
    }

    // /**
    //  * @return BdgAnnonce[] Returns an array of BdgAnnonce objects
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
    public function findOneBySomeField($value): ?BdgAnnonce
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
