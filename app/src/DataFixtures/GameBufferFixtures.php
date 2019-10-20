<?php

namespace App\DataFixtures;

use App\Entity\GameBuffer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use DateTimeImmutable;

class GameBufferFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $gameBuffer = (new GameBuffer())
            ->setLanguage('русский')
            ->setLeague('Лига чемпионов УЕФА')
            ->setSport('футбол')
            ->setTeamOne('Реал')
            ->setTeamTwo('Барселона')
            ->setDatetime(new DateTimeImmutable())
            ->setSource('sportdata.com');
        $manager->persist($gameBuffer);

        $gameBuffer = (new GameBuffer())
            ->setLanguage('ru')
            ->setLeague('Liga UEFA')
            ->setSport('futbol')
            ->setTeamOne('Real')
            ->setTeamTwo('Barcelona')
            ->setDatetime(new DateTimeImmutable())
            ->setSource('anotherdata.com');
        $manager->persist($gameBuffer);

        $gameBuffer = (new GameBuffer())
            ->setLanguage('en')
            ->setLeague('League UEFA')
            ->setSport('football')
            ->setTeamOne(' Real M')
            ->setTeamTwo('Barcelona')
            ->setDatetime(new DateTimeImmutable())
            ->setSource('anotherdata.com');
        $manager->persist($gameBuffer);

        $manager->flush();
    }
}
