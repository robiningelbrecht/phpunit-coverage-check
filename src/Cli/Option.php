<?php

namespace PHPUnitCoverageChecker\Cli;

use MyCLabs\Enum\Enum;

class Option extends Enum
{
    public const FORMATTER = 'formatter';
    public const PROCESSOR = 'processor';
    public const EXIT_ON_LOW_COVERAGE = 'exitOnLowCoverage';
    public const ENABLED_METRICS = 'enabledMetrics';

    public static function formatter(): self
    {
        return new self(self::FORMATTER);
    }

    public static function processor(): self
    {
        return new self(self::PROCESSOR);
    }

    public static function exitOnLowCoverage(): self
    {
        return new self(self::EXIT_ON_LOW_COVERAGE);
    }

    public static function enabledMetrics(): self
    {
        return new self(self::ENABLED_METRICS);
    }
}
