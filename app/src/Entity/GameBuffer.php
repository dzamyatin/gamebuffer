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

    public function getGameBufferToken(): ?GameBufferToken
    {
        return $this->gameBufferToken;
    }

    public function setGameBufferToken(GameBufferToken $gameBufferToken): self
    {
        $this->gameBufferToken = $gameBufferToken;

        // set the owning side of the relation if necessary
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
}
