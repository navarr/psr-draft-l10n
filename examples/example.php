<?php

use Psr\l10n\LocaleInterface;
use Psr\l10n\MessageInterface;
use Psr\l10n\MessageFormatterInterface;
use Psr\l10n\Utility\EnglishDefaultedLocale;
use Psr\l10n\Utility\Message;
use Psr\l10n\Utility\TranslationSingleton as T;

// Framework Code

class IcuMessageRenderer implements MessageFormatterInterface
{
    public function getTypes(): iterable
    {
        return ['icu'];
    }

    public function render(
        Stringable|string $message,
        iterable $parameters = [],
        ?LocaleInterface $locale = null
    ): MessageInterface {
        if (!$message instanceof MessageInterface) {
            $message = new Message((string)$message, (string)$message, $locale ?? new EnglishDefaultedLocale(), 'icu');
        }

        $localeString = $message->getLocale()->getTag();
        $formatter = new MessageFormatter($localeString, $message->getTranslation());
        $result = $formatter->format(is_array($parameters) ? $parameters : iterator_to_array($parameters));
        return $result !== false ? $result : $message;
    }
}

class CompositeTypeRenderer implements MessageFormatterInterface
{
    private array $renderers = [];

    public function register(MessageFormatterInterface $renderer)
    {
        foreach ($renderer->getTypes() as $type) {
            $this->renderers[$type] = $renderer;
        }
    }

    public function getTypes(): iterable
    {
        return array_keys($this->renderers);
    }

    public function render(
        Stringable|string $message,
        iterable $parameters = [],
        ?LocaleInterface $locale = null
    ): MessageInterface {
        if (!$message instanceof MessageInterface) {
            $message = new Message((string)$message, (string)$message, $locale ?? new EnglishDefaultedLocale(), 'icu');
        }

        // Lookup translation by $message->getIdentifier() and $message->getLocale()
        $translation = $message;

        $renderer = $this->renderers[$message->getFormatterType()] ?? null;
        if ($renderer === null) {
            throw new RuntimeException('No applicable renderer is registered with the composite');
        }

        return $renderer->render($translation, $parameters);
    }
}

$compositeRenderer = new CompositeTypeRenderer();
$compositeRenderer->register(new IcuMessageRenderer());

T::setRenderer($compositeRenderer);

// Component Code

// Simple use case using english as key

$name = 'Navarr Barnier';

echo T::render('Hello, {name}!', ['name' => $name]); // assumes en and ICU format

// Simple use case using key but providing translation

echo T::render('Hello, {name}!', ['name' => $name], id: 'welcome_banner'); // assumes en and ICU format

// Simple use case using translation as key but in another language

echo T::render(new Message('こんにちは、 {name}さん！', locale: new EnglishDefaultedLocale('ja')), ['name' => $name]);

// or

function __(string $message, array $parameters = []): Stringable
{
    $locale = new EnglishDefaultedLocale('ja');
    $message = new Message($message, locale: $locale);

    return T::render($message, $parameters);
}

echo __('こんにちは、 {name}さん！', ['name' => $name]);
