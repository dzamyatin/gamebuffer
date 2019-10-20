<?php

namespace App\Translator;

use Campo\UserAgent;
use Psr\Log\LoggerInterface;
use Stichoza\GoogleTranslate\GoogleTranslate;
use UnexpectedValueException;
use ErrorException;

class GoogleTranslator implements TranslatorInterface
{
    /** @var GoogleTranslate  */
    private $googleTranslate;
    /** @var LoggerInterface  */
    private $logger;

    public function __construct(GoogleTranslate $googleTranslate, LoggerInterface $logger)
    {
        $this->googleTranslate = $googleTranslate;
        $this->logger = $logger;
    }

    public function translate(string $string): ?string
    {
        try {
            $this->googleTranslate->setOptions(['headers' => [
                'User-Agent' => UserAgent::random()
            ]]);
            $text = $this->googleTranslate->translate($string);
        } catch (ErrorException|UnexpectedValueException $exception) {
            $this->logger->error($exception->getMessage());
            return null;
        }
        return $text;
    }
}