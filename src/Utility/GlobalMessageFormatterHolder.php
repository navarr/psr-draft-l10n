<?php

namespace Psr\l10n\Utility;

use Psr\l10n\LocaleInterface;
use Psr\l10n\MessageFormatterInterface;
use Psr\l10n\MessageInterface;

class GlobalMessageFormatterHolder
{
    private static MessageFormatterInterface $formatter;

    public static function setFormatter(MessageFormatterInterface $formatter)
    {
        static::$formatter = $formatter;
    }

    public static function getFormatter(): MessageFormatterInterface
    {
        return static::$formatter;
    }
}
