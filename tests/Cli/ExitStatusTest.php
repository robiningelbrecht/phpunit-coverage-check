<?php

namespace Tests\Cli;

use PHPUnit\Framework\TestCase;
use PHPUnitCoverageChecker\Cli\ExitStatus;
use Spatie\Snapshots\MatchesSnapshots;

class ExitStatusTest extends TestCase
{
    use MatchesSnapshots;

    public function testItShouldContainAllEnums(): void
    {
        $this->assertMatchesJsonSnapshot(ExitStatus::toArray());
    }
}
