<?php

namespace App\Manager;

use App\Entity\GameBuffer;
use App\Entity\GameBufferToken;
use Doctrine\ORM\EntityManagerInterface;

class MergeManager
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function process()
    {

//        $one = 'barca';
//        $two = 'barcelona';
//
//        $sim = similar_text($one, $two, $perc1);
//        var_dump($perc1);
//        $sim = similar_text($two, $one, $perc2);
//        var_dump($perc2);
//
//        var_dump(($perc2 + $perc1) / 200 * 100);
//
//        $cost_ins = 10;
//        $cost_rep = 0;
//        $cost_del = 10;
//        var_dump(levenshtein($one, $two, $cost_ins, $cost_rep, $cost_del));

    }

    private function makeToken(GameBuffer $gameBuffer)
    {
        $token = new GameBufferToken();
        $token->setGameBuffer($gameBuffer);

    }

    private function getLanguageToken(strung $language)
    {
        $gameBuffer->getLanguage();
    }
}