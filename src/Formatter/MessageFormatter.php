<?php

namespace PHPUnitCoverageChecker\Formatter;

class MessageFormatter implements Formatter
{
    public function formatSuccessMessage(float $expected_coverage, float $actual_coverage): string
    {
        return sprintf('%0.2f', $actual_coverage) . '% test coverage (min required is ' . sprintf('%0.2f', $expected_coverage) . '%), give yourself a pat on the back';
    }

    public function formatErrorMessage(float $expected_coverage, float $actual_coverage): string
    {
        return 'Expected ' . sprintf('%0.2f', $expected_coverage) . '% test coverage, got ' . sprintf('%0.2f', $actual_coverage) . '%';
    }

}