<?php

namespace PHPUnitCoverageChecker\Formatter;

interface Formatter
{
    public function formatSuccessMessage(float $expected_coverage, float $actual_coverage): string;

    public function formatErrorMessage(float $expected_coverage, float $actual_coverage): string;
}