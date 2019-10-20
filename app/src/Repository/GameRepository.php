<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use DateTimeImmutable;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    const DEFAULT_GAP = 26;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function findByInterval(DateTimeImmutable $dateTime, int $hours = self::DEFAULT_GAP)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.datetime BETWEEN :from AND :to')
            ->setParameter('from', $dateTime->modify("-$hours hours") )
            ->setParameter('to', $dateTime->modify("+$hours hours") )
            ->getQuery()
            ->getResult()
        ;
    }
}
