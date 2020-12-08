<?php

namespace App\Repository;

use App\Entity\AnnonceVideo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AnnonceVideo|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnnonceVideo|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnnonceVideo[]    findAll()
 * @method AnnonceVideo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceVideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnnonceVideo::class);
    }

    // /**
    //  * @return AnnonceVideo[] Returns an array of AnnonceVideo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AnnonceVideo
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
