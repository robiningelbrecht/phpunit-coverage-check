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

        $this->assertMatchesJsonSnapshot(array_map(fn (Parameter $argument) => $argument->raw(), $command->allArguments()));
        $this->assertMatchesJsonSnapshot(array_map(fn (Parameter $argument) => $argument->raw(), $command->allOptions()));
    }

    public function testItShouldGuardValidOptions(): void{
        $command = CoverageCheckerCommand::create();

        $command->parse(['bin/coverage-checker','clover.xml', '20', '--formatter=lol']);
    }
}
