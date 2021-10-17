<?php

namespace Tests\Cli;

use PHPUnit\Framework\TestCase;
use PHPUnitCoverageChecker\Cli\Argument;

class ArgumentTest extends TestCase
{
    public function testItShouldContainAllEnums(): void
    {
        $this->assertEquals([
            'FILE' => (string) Argument::file(),
            'PERCENTAGE' => (string) Argument::percentage(),
        ], Argument::toArray());
    }
}
