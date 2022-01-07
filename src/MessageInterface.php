<?php

namespace Psr\l10n;

use Stringable;

interface MessageInterface extends Stringable
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
     * @return string|null The context hierarchy of the message
     */
    public function getContext(): ?string;

    /**
     * @return string The message in the specified locale
     */
    public function getTranslation(): string;

    /**
     * @return string The type of formatter necessary to display the message with its given parameters
     */
    public function getFormatterType(): string;
}
