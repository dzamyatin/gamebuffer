<?php

namespace App\Repository;

use App\Entity\GameBufferToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GameBufferToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameBufferToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameBufferToken[]    findAll()
 * @method GameBufferToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameBufferTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameBufferToken::class);
    }

    // /**
    //  * @return GameBufferToken[] Returns an array of GameBufferToken objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GameBufferToken
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
