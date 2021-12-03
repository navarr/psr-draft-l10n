<?php

namespace Psr\l10n;

interface MessageFormatterInterface
{
    /**
     * @param MessageInterface|string $string The message to render
     * @param iterable<string|int, string> $parameters
     * @param ?LocaleInterface $locale When null, any formatter that would translate the text MUST use the current locale in context
     * @return string The rendered message
     */
    public function render(
        MessageInterface|string $string,
        iterable $parameters = [],
        ?LocaleInterface $locale = null
    ): string;

    /**
     * @return iterable<string> The message "types" the implementation is capable of rendering
     */
    public function getTypes(): iterable;
}
