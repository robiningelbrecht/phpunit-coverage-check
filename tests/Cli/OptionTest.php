<?php

namespace Tests\Cli;

use PHPUnit\Framework\TestCase;
use PHPUnitCoverageChecker\Cli\Option;
use Spatie\Snapshots\MatchesSnapshots;

class Optiontest extends TestCase
{
    use MatchesSnapshots;

    public function testItShouldContainAllEnums(): void
    {
        $this->assertMatchesJsonSnapshot(Option::toArray());
    }
}
