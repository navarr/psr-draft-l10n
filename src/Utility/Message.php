<?php

namespace Psr\l10n\Utility;

use Psr\l10n\LocaleInterface;
use Psr\l10n\MessageInterface;

class Message implements MessageInterface
{
    private readonly string $translation;

    public function __construct(
        private readonly string $id,
        ?string $translation = null,
        private readonly string $context = null,
        private readonly LocaleInterface $locale = new EnglishDefaultedLocale(),
        private readonly string $formatterType= 'icu'
    ){
        $this->translation = $translation ?? $this->id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getContext(): ?string
    {
        return $this->context;
    }

    public function getTranslation(): string
    {
        return $this->translation;
    }

    public function getLocale(): LocaleInterface
    {
        return $this->locale;
    }

    public function getFormatterType(): string
    {
        return $this->formatterType;
    }

    public function __toString(): string
    {
        return $this->translation;
    }
}
