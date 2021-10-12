<?php

namespace PHPUnitCoverageChecker\Processor;

use MyCLabs\Enum\Enum;

class ProcessorType extends Enum
{
    public const CLOVER_COVERAGE = 'clover-coverage';

    public static function cloverCoverage(): self
    {
        return new self(self::CLOVER_COVERAGE);
    }
}
