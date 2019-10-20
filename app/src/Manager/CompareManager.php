<?php

namespace App\Manager;

use App\Entity\Game;
use App\Entity\GameBuffer;
use App\Entity\GameBufferToken;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class CompareManager
{
    /** @var LoggerInterface */
    private $logger;
    /** @var EntityManagerInterface */
    private $entityManager;

    const REQUIRED_PERCENT_MATCH = 50;

    public function __construct(
        LoggerInterface $logger,
        EntityManagerInterface $entityManager
    ) {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    public function getSameGame(GameBuffer $gameBuffer): ?Game
    {
        /** @var GameRepository $gameRepository */
        $gameRepository = $this->entityManager->getRepository(Game::class);
        /** @var Game $game */
        foreach ($gameRepository->findByInterval($gameBuffer->getDatetime()) as $game) {
            if ($this->compare($gameBuffer->getGameBufferToken(), $game)) {
                return $game;
            }
        }
        return null;
    }

    private function compare(GameBufferToken $comparingGameBufferToken, Game $game): bool
    {
        foreach ($game->getGameBuffers() as $gameBuffer) {
            $gameBufferToken = $gameBuffer->getGameBufferToken();

            if ($this->isEqualTokens($comparingGameBufferToken, $gameBufferToken)) {
                return true;
            }
        }
        return false;
    }

    private function isEqualTokens(GameBufferToken $gameBufferTokenOne, GameBufferToken $gameBufferTokenTwo): bool
    {
        $sportEqual = $this->compareStrings($gameBufferTokenOne->getSport(), $gameBufferTokenTwo->getSport());
        $leagueEqual = $this->compareStrings($gameBufferTokenOne->getLeague(), $gameBufferTokenTwo->getLeague());
        $teamEqual = (
                $this->compareStrings($gameBufferTokenOne->getTeamTwo(), $gameBufferTokenTwo->getTeamTwo()) &&
                $this->compareStrings($gameBufferTokenOne->getTeamOne(), $gameBufferTokenTwo->getTeamOne())
            ) || (
                $this->compareStrings($gameBufferTokenOne->getTeamTwo(), $gameBufferTokenTwo->getTeamOne()) &&
                $this->compareStrings($gameBufferTokenOne->getTeamOne(), $gameBufferTokenTwo->getTeamTwo())
            );

        return $sportEqual && $leagueEqual && $teamEqual;
    }

    private function compareStrings(string $stringOne, string $stringTwo): bool
    {
        similar_text($stringOne, $stringTwo, $perc);

        return $perc > self::REQUIRED_PERCENT_MATCH;
    }
}