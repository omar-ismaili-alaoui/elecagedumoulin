<?php

namespace App\Repository;

use App\Entity\PageVideos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PageVideos|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageVideos|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageVideos[]    findAll()
 * @method PageVideos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageVideosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageVideos::class);
    }

    // /**
    //  * @return PageVideos[] Returns an array of PageVideos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PageVideos
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
