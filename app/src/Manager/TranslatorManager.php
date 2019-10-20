<?php

namespace App\Manager;

use App\Event\TranslatedEvent;
use App\Translator\TranslatorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class TranslatorManager
{
    /** @var TranslatorInterface[] */
    private $translators;
    /** @var LoggerInterface */
    private $logger;
    /** @var EventDispatcherInterface */
    private $dispatcher;

    /**
     * TranslatorManager constructor.
     * @param TranslatorInterface[] $translators
     */
    public function __construct($translators, EventDispatcherInterface $dispatcher, LoggerInterface $logger)
    {
        $this->dispatcher = $dispatcher;
        $this->logger = $logger;
        foreach ($translators as $translator) {
            $this->register($translator);
        }
    }

    private function register(TranslatorInterface $translator)
    {
        $this->translators[] = $translator;
    }

    public function translate(string $text): ?string
    {
        foreach ($this->translators as $translator) {
            $result = $translator->translate($text);
            if (!is_null($result)) {
                $this->dispatcher->dispatch(
                    new TranslatedEvent($translator, $text, $result),
                    TranslatedEvent::NAME
                );
                return $result;
            }
        }
        $this->logger->error('Can\'t translate the word: ' . $text);
        return null;
    }
}