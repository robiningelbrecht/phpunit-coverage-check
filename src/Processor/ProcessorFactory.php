<?php

namespace PHPUnitCoverageChecker\Processor;

abstract class ProcessorFactory
{
    public static function fromString(string $string): Processor
    {
        if (ProcessorType::cloverCoverage() == $string) {
            return new CloverCoverageProcessor();
        }
        if (ProcessorType::textCoverage() == $string) {
            return new TextCoverageProcessor();
        }

        throw new \InvalidArgumentException(sprintf('Invalid processor "%s". %s allowed', $string, implode(', ', ProcessorType::toArray())));
    }
}
