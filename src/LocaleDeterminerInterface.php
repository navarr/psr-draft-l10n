<?php

namespace Psr\l10n;

interface LocaleDeterminerInterface
{
    /**
     * Retrieve the locale to be used in the context of the caller
     */
    public function getLocale(): LocaleInterface;
}
