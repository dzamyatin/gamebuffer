<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameBufferTokenRepository")
 */
class GameBufferToken
{
    use GameTokenTrait;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotNull
     * @Assert\Language
     */
    protected $language;

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

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     */
    protected $sport;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     */
    protected $league;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     */
    protected $teamOne;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     */
    protected $teamTwo;

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
