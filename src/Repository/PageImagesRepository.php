<?php

namespace App\Repository;

use App\Entity\PageImages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PageImages|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageImages|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageImages[]    findAll()
 * @method PageImages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageImagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageImages::class);
    }

    // /**
    //  * @return PageImages[] Returns an array of PageImages objects
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
    public function findOneBySomeField($value): ?PageImages
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
