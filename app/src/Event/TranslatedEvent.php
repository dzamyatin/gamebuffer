<?php

namespace App\Event;

use App\Translator\TranslatorInterface;
use Symfony\Contracts\EventDispatcher\Event;

class TranslatedEvent extends Event
{
    public const NAME = 'translated';

    /** @var TranslatorInterface */
    private $translator;
    /** @var string */
    private $source;
    /** @var string */
    private $translation;

    public function __construct(TranslatorInterface $translator, string $source, string $translation)
    {
        $this->translator = $translator;
        $this->source = $source;
        $this->translation = $translation;
    }

    public function getTranslator()
    {
        return $this->translator;
    }

    public function getTranslation(): string
    {
        return $this->translation;
    }

    public function getSource(): string
    {
        return $this->source;
    }
}