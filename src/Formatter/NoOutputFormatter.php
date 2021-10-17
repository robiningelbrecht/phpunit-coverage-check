<?php

namespace PHPUnitCoverageChecker\Formatter;

class NoOutputFormatter implements Formatter
{
    public function formatSuccessMessage(float $expected_coverage, float $actual_coverage): string
    {
        return '';
    }

    public function formatErrorMessage(float $expected_coverage, float $actual_coverage): string
    {
        return '';
    }
}
