<?php

namespace Psr\l10n;

interface MessageFormatterInterface
{
    /**
     * @param string $string The message to render
     * @param iterable<string|int, string> $parameters
     * @return string The rendered message
     */
    public function render(string $string, iterable $parameters = []): string;
    
    /**
     * @return iterable<string> The message "types" the implementation is capable of rendering
     */
    public function getTypes(): iterable;
}
