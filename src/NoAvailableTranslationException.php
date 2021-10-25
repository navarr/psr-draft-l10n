<?php

namespace Psr\l10n;

use Exception;

/**
 * Thrown when a requested message was not found by the LocalisableStringRepository
 */
class NoAvailableTranslationException extends Exception
{

}
