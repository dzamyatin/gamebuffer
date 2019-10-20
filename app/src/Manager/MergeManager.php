<?php

namespace App\Manager;

use App\Entity\Game;
use App\Entity\GameBuffer;
use App\Entity\GameBufferToken;
use App\Repository\GameBufferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MergeManager
{
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var TokenizerManager */
    private $tokenizerManager;
    /** @var CompareManager */
    private $compareManager;
    /** @var ValidatorInterface */
    private $validator;
    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        EntityManagerInterface $entityManager,
        TokenizerManager $tokenizerManager,
        CompareManager $compareManager,
        ValidatorInterface $validator,
        LoggerInterface $logger
    ) {
        $this->entityManager = $entityManager;
        $this->compareManager = $compareManager;
        $this->tokenizerManager = $tokenizerManager;
        $this->validator = $validator;
        $this->logger = $logger;
    }

    public function process(): void
    {
        /** @var GameBufferRepository $gameBufferRepository */
        $gameBufferRepository = $this->entityManager->getRepository(GameBuffer::class);

        foreach ($gameBufferRepository->gameBufferIterator() as $gameBuffer) {
            $gameBuffer->setProcessed(true);
            $this->assignToken($gameBuffer);
            $this->entityManager->flush();
            $this->merge($gameBuffer, $this->compareManager->getSameGame($gameBuffer));
        }
    }

    private function merge(GameBuffer $gameBuffer, ?Game $game = null): void
    {
        if (is_null($game)) {
            $game = new Game();
            $this->entityManager->persist($game);
        }
        $game->setSport($gameBuffer->getSport());
        $game->setTeamOne($gameBuffer->getTeamOne());
        $game->setTeamTwo($gameBuffer->getTeamTwo());
        $game->setSource($gameBuffer->getSource());
        $game->setLeague($gameBuffer->getLeague());
        $game->setLanguage($gameBuffer->getLanguage());
        $game->setDatetime($gameBuffer->getDatetime());
        $game->addGameBuffer($gameBuffer);

        $this->entityManager->flush();
    }

    private function assignToken(GameBuffer $gameBuffer): void
    {
        $token = new GameBufferToken();
        $this->tokenizerManager->tokenize($gameBuffer, $token);
        if ($errors = (string)$this->validator->validate($token)) {
            $this->logger->error(
                'Can\'t make token for gameBuffer: '
                . $gameBuffer->getId()
                . ' by errors: ' . $errors
            );
        }
        $gameBuffer->setGameBufferToken($token);
    }
}