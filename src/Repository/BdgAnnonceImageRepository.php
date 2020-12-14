<?php

namespace App\Repository;

use App\Entity\BdgAnnonceImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BdgAnnonceImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method BdgAnnonceImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method BdgAnnonceImage[]    findAll()
 * @method BdgAnnonceImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BdgAnnonceImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BdgAnnonceImage::class);
    }

    // /**
    //  * @return BdgAnnonceImage[] Returns an array of BdgAnnonceImage objects
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
    public function findOneBySomeField($value): ?BdgAnnonceImage
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
