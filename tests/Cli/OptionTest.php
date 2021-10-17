<?php

namespace Tests\Cli;

use PHPUnit\Framework\TestCase;
use PHPUnitCoverageChecker\Cli\Option;

class Optiontest extends TestCase
{
    public function testItShouldContainAllEnums(): void
    {
        $this->assertEquals([
            'FORMATTER' => (string) Option::formatter(),
            'PROCESSOR' => (string) Option::processor(),
            'EXIT_ON_LOW_COVERAGE' => (string) Option::exitOnLowCoverage(),
            'ENABLED_METRICS' => (string) Option::enabledMetrics(),
        ], Option::toArray());
    }
}
