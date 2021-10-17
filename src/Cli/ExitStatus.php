<?php

namespace PHPUnitCoverageChecker\Cli;

use MyCLabs\Enum\Enum;

class ExitStatus extends Enum
{
    public const ERROR = 1;
    public const OK = 0;

    public static function error(): self
    {
        return new self(self::ERROR);
    }

    public static function ok(): self
    {
        return new self(self::OK);
    }
}
