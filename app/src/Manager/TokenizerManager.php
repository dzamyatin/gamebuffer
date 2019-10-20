<?php

namespace App\Manager;

use App\Entity\GameBuffer;
use App\Entity\GameBufferToken;
use Psr\Log\LoggerInterface;
use Symfony\Component\Intl\Languages;
use Wamania\Snowball\English;

class TokenizerManager
{
    const LANG_RU = 'ru';
    const LANG_EN = 'en';

    /** @var LoggerInterface */
    private $logger;
    /** @var English */
    private $stemmer;
    /** @var TranslatorManager */
    private $translatorManager;

    public function __construct(
        TranslatorManager $translatorManager,
        LoggerInterface $logger,
        English $stemmer
    ) {
        $this->stemmer = $stemmer;
        $this->logger = $logger;
        $this->translatorManager = $translatorManager;
    }

    public function tokenize(GameBuffer $gameBuffer, GameBufferToken $gameBufferToken): void
    {
        $languageToken = $this->distinguishLanguage((string)$gameBuffer->getLanguage());
        $gameBufferToken->setLanguage($languageToken);
        $gameBufferToken->setLeague($this->distinguishToken($gameBuffer->getLeague(), $languageToken));
        $gameBufferToken->setTeamTwo($this->distinguishToken($gameBuffer->getTeamOne(), $languageToken));
        $gameBufferToken->setTeamOne($this->distinguishToken($gameBuffer->getTeamTwo(), $languageToken));
        $gameBufferToken->setSport($this->distinguishToken($gameBuffer->getSport(), $languageToken));
    }

    private function processLanguage(string $language): ?string
    {
        if (!ctype_alpha($language)) {
            $language = transliterator_transliterate('Any-Latin; Latin-ASCII;', $language);
        }

        if (Languages::exists($language)) {
            return $language;
        }

        foreach (Languages::getLanguageCodes() as $code) {
            if (stripos($language, $code) === 0) {
                return $code;
            }
        }

        return null;
    }

    private function distinguishLanguage(string $language): ?string
    {
        if (!$languageToken = (string)$this->processLanguage((string)$language)) {
            $this->logger->error("Can't distinguish language from: " . $language);
            return null;
        }
        if (!in_array($languageToken, [self::LANG_EN, self::LANG_RU])) {
            $this->logger->error("Language isn't supported: " . $languageToken);
            return null;
        }
        return $languageToken;
    }

    private function distinguishToken(string $text, string $languageToken)
    {
        $words = explode(' ', $text);
        $words = array_filter($words, function ($word) {
            return strlen($word) > 2;
        });
        $words = array_map(function ($word) use ($languageToken) {
            //@TODO make relocate processes to different classes as pipes
            $word = $this->processCommon((string)$word, $languageToken);
            $word = $this->processRussianTransliterate((string)$word, $languageToken);
            $word = $this->processRussianTranslate((string)$word, $languageToken);
            $word = $this->processTokenizer((string)$word, $languageToken);
            return $word;
        }, $words);
        sort($words);
        return implode(' ', $words);
    }

    private function processCommon(string $string, string $language): ?string
    {
        return strtolower($string);
    }

    private function processRussianTranslate(string $string, string $language): ?string
    {
        //@TODO ->isSupported
        if ($language != self::LANG_RU) {
            return $string;
        }

        return $this->translatorManager->translate($string);
    }

    private function processRussianTransliterate(string $string, string $language): ?string
    {
        if (
            $language != self::LANG_RU ||
            ($language == self::LANG_RU && preg_match('/[А-Яа-яЁё]/u', $string))
        ) {
            return $string;
        }

        return transliterator_transliterate('Any-Cyrillic;', $string);
    }

    private function processTokenizer(string $string, string $language): ?string
    {
        $string = $this->stemmer->stem($string);
        $string = metaphone($string, 3);
        return $string;
    }
}