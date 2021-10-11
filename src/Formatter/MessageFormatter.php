<?php

namespace PHPUnitCoverageChecker\Formatter;

class MessageFormatter implements Formatter
{
    public function formatSuccessMessage(float $expected_coverage, float $actual_coverage): string
    {
        return $actual_coverage . '% test coverage (min required is ' . $expected_coverage . '%), give yourself a pat on the back';
    }

    public function formatErrorMessage(float $expected_coverage, float $actual_coverage): string
    {
        return 'Expected ' . $expected_coverage . '% test coverage, got ' . $actual_coverage . '%';
    }

}