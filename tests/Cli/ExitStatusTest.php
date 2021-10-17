<?php

namespace Tests\Cli;

use PHPUnit\Framework\TestCase;
use PHPUnitCoverageChecker\Cli\ExitStatus;

class ExitStatusTest extends TestCase
{
    public function testItShouldContainAllEnums(): void
    {
        $this->assertEquals([
            'ERROR' => (string) ExitStatus::error(),
            'OK' => (string) ExitStatus::ok(),
        ], ExitStatus::toArray());
    }
}
