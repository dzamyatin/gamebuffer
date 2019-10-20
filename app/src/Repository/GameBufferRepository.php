<?php

namespace App\Repository;

use App\Entity\GameBuffer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Generator;

/**
 * @method GameBuffer|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameBuffer|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameBuffer[]    findAll()
 * @method GameBuffer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameBufferRepository extends ServiceEntityRepository
{

    const PAGE_SIZE = 100;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameBuffer::class);
    }

    public function gameBufferIterator(): Generator
    {
        $offset = 0;
        while ($gameBufferList = $this->findBy(
            ['processed' => false],
            null,
            self::PAGE_SIZE,
            $offset
        )) {
            $offset += self::PAGE_SIZE;
            yield from $gameBufferList;
        }
    }
}
