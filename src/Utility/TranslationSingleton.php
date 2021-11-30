<?php

namespace Psr\l10n;

use Psr\l10n\LocaleInterface;
use Psr\l10n\MessageFormatterInterface;
use Psr\l10n\MessageInterface;

class TranslationSingleton
{
    private static MessageFormatterInterface $renderer;

    public static function setRenderer(MessageFormatterInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public static function render(MessageInterface|string $message, iterable $parameters = [], ?string $id = null, ?LocaleInterface $locale = null)
    {
        $message = $message instanceof MessageInterface ? $message : new Message($id ?? $message, $message);
        return $this->renderer->render($message, $parameters, $locale);
    }
}