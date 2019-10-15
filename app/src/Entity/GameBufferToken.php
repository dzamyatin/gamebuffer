<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameBufferTokenRepository")
 */
class GameBufferToken
{
    use GameTokenTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\GameBuffer", inversedBy="gameBufferToken", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $gameBuffer;

    public function getGameBuffer(): ?GameBuffer
    {
        return $this->gameBuffer;
    }

    public function setGameBuffer(GameBuffer $gameBuffer): self
    {
        $this->gameBuffer = $gameBuffer;

        return $this;
    }
}
