<?php

namespace Psr\l10n;

interface LocaleInterface
{
    /**
     * @return string A BCP-47 code
     */
    public function getTag(): string;
}
