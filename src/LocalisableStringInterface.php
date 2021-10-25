<?php

namespace Psr\l10n;

interface LocalisableStringInterface
{
    /**
     * @return LocaleInterface The locale the message was written in
     */
    public function getLocale(): LocaleInterface;

    /**
     * @return string The unique identifier of the message across all translations
     */
    public function getIdentifier(): string;

    /**
     * @return string The message in the given locale
     */
    public function getTranslation(): string;

    /**
     * @return string The type of renderer necessary to display the message with its given parameters
     */
    public function getRendererType(): string;
}
