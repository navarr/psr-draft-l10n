<?php

/**
 * Disclaimer: Psuedo-code to demonstrate how a gettext backend might work in this current iteration of concepts
 */
class GettextTranslator implements MessageFormatterInterface
{
    public function __construct()
    {
        // Configure default domain
        bindtextdomain("phpapp", "/var/www/app/locale");
    }

    private function getFormatterForType(string $type): MessageFormatterInterface 
    {
        /* Left as an exercise to the reader */
    }

    private function getDefaultLocale(): LocaleInterface
    {
        /* Left as an exercise to the reader */
        return new LocaleInterface('en-US');
    }

    public function render(Stringable|string $message, iterable $parameters = [], ?LocaleInterface $locale = null): MessageInterface
    {
        $message = $message instanceof MessageInterface ? $message : new MessageInterface($message);

        $locale = $locale ?? $this->getDefaultLocale();
        $localeCode = str_replace('-', '_', $locale->getTag());
        
        // Update locale we're searching for
        putenv('LC_ALL='.$localeCode);
        setlocale(LC_ALL, $localeCode);

        // Ensure we're in the correct domain for lookup
        textdomain("phpapp");

        $id = $message instanceof MessageInterface ? $message->getId() : (string)$message;

        $paramaterArray = is_array($parameters) ? $parameters : iterator_to_array($parameters);

        // Perform the data store lookup.  It may optinally perform some formatting on the message
        $result = gettext($id);

        // but what about ngettext?  Well, that could be supported with additional metadata on the MessageInterface, so long as the MessageInterface
        // is what is passed to the `render` method.  ->getPluralId() and ->getPluralCount().
        // ngettext is a weird requirement of the gettext system to have different ids for plurals and non-plurals.  Very weird.

        if ($result === $id) {
            // If gettext returns the id we gave it, then set the result to the message given to us (instead of the id - in case of difference)
            $result = $message;
        }

        // very psuedo code
        $resultMessage = new MessageInterface(id: $message->getId(), message: $result, formatterType: $message->getFormatterType());

        $formatter = $this->getFormatterForType($message->getFormatterType());
        return $formatter->render($resultMessage, $parameters, $locale);
    }
}