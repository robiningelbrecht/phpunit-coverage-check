<?php

namespace PHPUnitCoverageChecker\Processor;

abstract class ProcessorFactory
{
    public const CLOVER_COVERAGE = 'clover-coverage';
    private const ALL = [
        self::CLOVER_COVERAGE,
    ];

    public static function fromString(string $string): Processor
    {
        if ($string === self::CLOVER_COVERAGE) {
            return new CloverCoverageProcessor();
        }

        throw new \InvalidArgumentException(sprintf('Invalid processor "%s". %s allowed', $string, implode(self::ALL)));
    }
}