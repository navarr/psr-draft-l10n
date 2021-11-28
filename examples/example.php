<?php

use Psr\l10n\LocaleInterface;
use Psr\l10n\LocalisableStringInterface;
use Psr\l10n\LocalisableStringRendererInterface;
use Psr\l10n\Utility\TranslationSingleton as T;

// Framework Code

class IcuMessageRenderer implements LocalisableStringRendererInterface
{
    public function getTypes(): iterable
    {
        return ['icu'];
    }

    public function render(LocalisableStringInterface $message, iterable $parameters = []): string
    {
        $localeString = $message->getLocale()->getTag();
        $formatter = new MessageFormatter($localeString, $message->getTranslation());
        $result = $formatter->format(is_array($parameters) ? $parameters : iterator_to_array($parameters));
        return $result !== false ? $result : $message->getTranslation();
    }
}

class CompositeTypeRenderer implements LocalisableStringRendererInterface
{
    private array $renderers = [];

    public function register(LocalisableStringRendererInterface $renderer)
    {
        $this->renderers[] = $renderer;
    }

    public function getTypes(): iterable
    {
        $types = array_map(
            static function(LocalisableStringRendererInterface $renderer) {
                return $renderer->getTypes();
            },
            $this->renderers
        );
        return array_unique(array_merge(...$types));
    }

    public function render(LocalisableStringInterface $message, iterable $parameters = []): string
    {
        // Lookup translation by $message->getIdentifier() and $message->getLocale()
        $translation = $message;

        $renderer = null;
        foreach ($this->renderers as $prospectiveRenderer) {
            if (in_array($translation->getRendererType(), $prospectiveRenderer->getTypes())) {
                $renderer = $prospectiveRenderer;
                break;
            }
        }

        if ($renderer === null) {
            throw new \RuntimeException('No applicable renderer is registered with the composite');
        }

        return $renderer->render($translation, $parameters);
    }
}

$compositeRenderer = new CompositeRenderer();
$compositeRenderer->register(new IcuMessageRenderer());

T::setRenderer($compositeRenderer);

// Component Code

// Simple use case using english as key

echo T::render('Hello, {name}!', ['name' => $name]); // assumes en and ICU format

// Simple use case using key but providing translation

echo T::render(id: 'welcome_banner', 'Hello, {name}!', ['name' => $name]); // assumes en and ICU format

// Simple use case using translation as key but in another language

echo T::render(new Message('こんにちは、 {name}さん！', locale: new Locale('ja')), ['name' => $name]);

// or

function __(string $message, array $parameters = []):string {
    $locale = new Locale('ja');
    $message = new Message($message, locale: $locale);

    return T::render($message, $parameters);
}

echo __('こんにちは、 {name}さん！', ['name' => $name]);