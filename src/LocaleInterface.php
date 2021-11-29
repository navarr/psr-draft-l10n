<?php

namespace Psr\l10n;

interface LocaleInterface
{
    /**
     * @return string A {@link https://tools.ietf.org/html/bcp47 BCP-47} code
     * @link https://tools.ietf.org/html/bcp47
     */
    public function getTag(): string;
}
