<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CacheTranslatorRepository")
 */
class CacheTranslator
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $translation;

    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $source;

    public function getTranslation(): ?string
    {
        return $this->translation;
    }

    public function setTranslation(string $translation): self
    {
        $this->translation = $translation;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }
}
