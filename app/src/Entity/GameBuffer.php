<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameBufferRepository")
 */
class GameBuffer extends AbstractGame
{
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\GameBufferToken", mappedBy="gameBuffer", cascade={"persist", "remove"})
     */
    private $gameBufferToken;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Game", inversedBy="gameBuffers")
     */
    private $game;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $processed = false;

    public function getGameBufferToken(): ?GameBufferToken
    {
        return $this->gameBufferToken;
    }

    public function setGameBufferToken(GameBufferToken $gameBufferToken): self
    {
        $this->gameBufferToken = $gameBufferToken;

        if ($this !== $gameBufferToken->getGameBuffer()) {
            $gameBufferToken->setGameBuffer($this);
        }

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getProcessed(): ?bool
    {
        return $this->processed;
    }

    public function setProcessed(bool $processed): self
    {
        $this->processed = $processed;

        return $this;
    }
}
