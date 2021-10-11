<?php

namespace PHPUnitCoverageChecker\Formatter;

class OnlyPercentageFormatter implements Formatter
{
    public function formatSuccessMessage(float $expected_coverage, float $actual_coverage): string
    {
        return $actual_coverage;
    }

    public function formatErrorMessage(float $expected_coverage, float $actual_coverage): string
    {
        return $actual_coverage;
    }


}