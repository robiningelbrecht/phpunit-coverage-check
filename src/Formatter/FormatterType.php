<?php

namespace PHPUnitCoverageChecker\Formatter;

use MyCLabs\Enum\Enum;

class FormatterType extends Enum
{
    public const ONLY_PERCENTAGE = 'only-percentage';
    public const MESSAGE = 'message';

    public static function onlyPercentage(): self
    {
        return new self(self::ONLY_PERCENTAGE);
    }

    public static function message(): self
    {
        return new self(self::MESSAGE);
    }
}
