<?php

namespace PHPUnitCoverageChecker\Formatter;

use MyCLabs\Enum\Enum;

class FormatterType extends Enum
{
    public const ONLY_PERCENTAGE = 'only-percentage';
    public const MESSAGE = 'message';
    public const NO_OUTPUT = 'no-output';

    public static function onlyPercentage(): self
    {
        return new self(self::ONLY_PERCENTAGE);
    }

    public static function message(): self
    {
        return new self(self::MESSAGE);
    }

    public static function noOutput(): self
    {
        return new self(self::NO_OUTPUT);
    }
}
