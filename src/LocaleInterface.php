<?php

namespace Psr\l10n;

interface LocaleInterface
{
    /**
     * @return string An ISO 639-3 language code
     */
    public function getLanguageCode(): string;

    /**
     * @return ?string A dialect or variant of the language code.  This must be either a 3 character ISO 3166-1 code
     * or an arbitrary string with a length not equal to 3 characters.
     */
    public function getVariantCode(): ?string;
}
