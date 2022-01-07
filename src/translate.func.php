<?php

namespace Psr\l10n;

function translate(Stringable|string $message, iterable $parameters = [], ?string $context = null, ?string $id = null, ?LocaleInterface $locale = null): MessageInterface
{
    $message = $message instanceof MessageInterface ? $message : new Message($id ?? (string)$message, (string)$message, $context);
    return GlobalMessageFormatterHolder::getFormatter()->render($message, $parameters, $locale);
}