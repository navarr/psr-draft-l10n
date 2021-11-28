<?php

namespace Psr\l10n\Utility;

class Message implements LocalisableStringInterface
{
    private readonly string $translation;

    public function __construct(
        private readonly string $identifier,
        ?string $translation = null,
        private readonly LocaleInterface $locale = new Locale(),
        private readonly string $rendererType= 'icu'
    ){
        $this->translation = $translation ?? $this->identifier;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getTranslation(): string
    {
        return $this->translation;
    }

    public function getLocale(): LocaleInterface
    {
        return $this->locale;
    }

    public function getRendererType(): string
    {
        return $this->rendererType;
    }
}