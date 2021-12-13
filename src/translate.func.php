<?php

namespace Psr\l10n;

function translate(Stringable|string $message, iterable $parameters = [], ?string $id = null, ?LocaleInterface $locale = null): MessageInterface
{
    $message = $message instanceof MessageInterface ? $message : new Message($id ?? (string)$message, (string)$message);
    return GlobalMessageFormatterHolder::getFormatter()->render($message, $parameters, $locale);
}