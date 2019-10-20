<?php

namespace App\Translator;

interface TranslatorInterface
{
    public function translate(string $string): ?string;
}
