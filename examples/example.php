<?php

use Psr\l10n\LocaleDeterminerInterface;
use Psr\l10n\LocaleInterface;
use Psr\l10n\LocalisableStringInterface;
use Psr\l10n\LocalisableStringRendererInterface;
use Psr\l10n\LocalisableStringRepositoryInterface;
use Psr\l10n\NoAvailableTranslationException;

/**
 * @template T
 */
class ServiceLocator
{
    /**
     * @param class-string<T> $object
     * @return T
     */
    public static function get(string $object): mixed
    {
        return new $object();
    }
}

class EnglishLocale implements LocaleInterface
{
    private static self $instance;

    public static function get(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getLanguageCode(): string
    {
        return 'eng';
    }

    public function getVariantCode(): ?string
    {
        return 'USA';
    }
}

class SimpleMessage implements LocalisableStringInterface
{
    private string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function getLocale(): LocaleInterface
    {
        return EnglishLocale::get();
    }

    public function getIdentifier(): string
    {
        return $this->message;
    }

    public function getTranslation(): string
    {
        return $this->message;
    }

    public function getRendererType(): string
    {
        return 'sprintf';
    }
}

class SprintfMessageRenderer implements LocalisableStringRendererInterface
{
    public function render(LocaleInterface $locale, string $string, iterable $parameters = []): string
    {
        return sprintf($string, is_array($parameters) ? $parameters : iterator_to_array($parameters));
    }
}

function __(string $message, array $arguments = []): string
{
    $localeDeterminer = ServiceLocator::get(LocaleDeterminerInterface::class);
    $translationRepository = ServiceLocator::get(LocalisableStringRepositoryInterface::class);
    $renderer = ServiceLocator::get(LocalisableStringRendererInterface::class);

    $message = new SimpleMessage($message);
    try {
        $translatedMessage = $translationRepository->getTranslation(
            $message->getIdentifier(),
            $localeDeterminer->getLocale()
        );
    } catch (NoAvailableTranslationException $exception) {
        $translatedMessage = $message;
    }

    return $renderer->render(
        $translatedMessage->getLocale(),
        $translatedMessage->getTranslation(),
        $arguments
    );
}

echo __('Hello, World!');
