<?php

namespace Psr\l10n;

interface LocalisableStringRepositoryInterface
{
    /**
     * @param string $identifier The unique identifier of the message to retrieve
     * @param LocaleInterface|null $locale The variant of the message to retrieve
     * @return LocalisableStringInterface
     * @throws NoAvailableTranslationException
     */
    public function getTranslation(string $identifier, ?LocaleInterface $locale): LocalisableStringInterface;

    /**
     * @param LocalisableStringInterface $localisableString
     */
    public function addTranslation(LocalisableStringInterface $localisableString): void;
}
