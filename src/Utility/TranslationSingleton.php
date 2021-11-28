<?php

namespace Psr\l10n;

class TranslationSingleton
{
    private static TranslationRendererInterface $renderer;

    public static function setRenderer(TranslationRendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public static function render(LocalisableStringInterface|string $message, iterable $parameters = [], ?string $id = null)
    {
        $message = $message instanceof LocalisableStringInterface ? $message : new Message($id ?? $message, $message);
        return $this->renderer->render($message, $parameters);
    }
}