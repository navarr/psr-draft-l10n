<?php

namespace Psr\l10n\Utility;

class Locale implements LocaleInterface
{
    public function __construct(
        private readonly string $tag = 'en'
    ) {}

    public function getTag(): string
    {
        return $this->tag;
    }
}