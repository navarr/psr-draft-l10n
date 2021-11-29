<?php

namespace Psr\l10n;

interface MessageInterface
{
    /**
     * @return LocaleInterface The locale this message is written in
     */
    public function getLocale(): LocaleInterface;

    /**
     * @return string The unique identifier of the message across all translations
     */
    public function getId(): string;

    /**
     * @return string The message in the given locale
     */
    public function getTranslation(): string;

    /**
     * @return string The type of formatter necessary to display the message with its given parameters
     */
    public function getFormatterType(): string;
}
