<?php

namespace App\Repository;

use App\Entity\CacheTranslator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CacheTranslator|null find($id, $lockMode = null, $lockVersion = null)
 * @method CacheTranslator|null findOneBy(array $criteria, array $orderBy = null)
 * @method CacheTranslator[]    findAll()
 * @method CacheTranslator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CacheTranslatorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CacheTranslator::class);
    }

    // /**
    //  * @return CacheTranslator[] Returns an array of CacheTranslator objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CacheTranslator
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
