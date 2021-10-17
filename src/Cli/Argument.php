<?php

namespace PHPUnitCoverageChecker\Cli;

use MyCLabs\Enum\Enum;

class Argument extends Enum
{
    public const FILE = 'file';
    public const PERCENTAGE = 'percentage';

    public static function file(): self
    {
        return new self(self::FILE);
    }

    public static function percentage(): self
    {
        return new self(self::PERCENTAGE);
    }
}
