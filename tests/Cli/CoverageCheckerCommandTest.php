<?php

namespace Tests\Cli;

use Ahc\Cli\Input\Parameter;
use PHPUnit\Framework\TestCase;
use PHPUnitCoverageChecker\Cli\CoverageCheckerCommand;
use Spatie\Snapshots\MatchesSnapshots;

class CoverageCheckerCommandTest extends TestCase
{
    use MatchesSnapshots;

    public function testItShouldCreateCommandWithOptionsAndArguments(): void
    {
        $command = CoverageCheckerCommand::create();

        $this->assertMatchesSnapshot(array_map(fn (Parameter $argument) => $argument->raw(), $command->allArguments()));
        $this->assertMatchesSnapshot(array_map(fn (Parameter $argument) => $argument->raw(), $command->allOptions()));
    }
}
