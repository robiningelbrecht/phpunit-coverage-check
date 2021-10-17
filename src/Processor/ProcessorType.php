<?php

namespace PHPUnitCoverageChecker\Processor;

use MyCLabs\Enum\Enum;

class ProcessorType extends Enum
{
    public const CLOVER_COVERAGE = 'clover-coverage';
    public const TEXT_COVERAGE = 'text-coverage';

    public static function cloverCoverage(): self
    {
        return new self(self::CLOVER_COVERAGE);
    }

    public static function textCoverage(): self
    {
        return new self(self::TEXT_COVERAGE);
    }
}
