<?php

namespace Psr\l10n;

interface LocalisableStringRendererInterface
{
    /**
     * @param LocaleInterface $locale The locale the message to be rendered is in
     * @param string $string The message to render
     * @param iterable<string|int, string> $parameters
     * @return string The rendered message
     */
    public function render(LocaleInterface $locale, string $string, iterable $parameters = []): string;
}
