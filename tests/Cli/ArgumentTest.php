<?php

namespace Tests\Cli;

use PHPUnit\Framework\TestCase;
use PHPUnitCoverageChecker\Cli\Argument;
use Spatie\Snapshots\MatchesSnapshots;

class ArgumentTest extends TestCase
{
    use MatchesSnapshots;

    public function testItShouldContainAllEnums(): void
    {
        $this->assertMatchesJsonSnapshot(Argument::toArray());
    }
}
