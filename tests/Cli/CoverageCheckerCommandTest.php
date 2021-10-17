<?php

namespace Tests\Cli;

use Ahc\Cli\Input\Parameter;
use PHPUnit\Framework\TestCase;
use PHPUnitCoverageChecker\Cli\CoverageCheckerCommand;
use RuntimeException;
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

    public function testItShouldParse(): void
    {
        $command = CoverageCheckerCommand::create();

        $command->parse([
           'bin/coverage-checker',
           '../clover.xml',
           '20',
           '--formatter=message',
           '--processor=clover-coverage',
           '--exit-on-low-coverage',
           '--enabled-metrics=one,two,three',
        ]);

        $this->assertMatchesJsonSnapshot($command->getArgumentValues());
        $this->assertMatchesJsonSnapshot($command->getOptionValues());
    }

    public function testItShouldThrowWhenInvalidFormatter(): void
    {
        $command = CoverageCheckerCommand::create();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Invalid formatter "test". Valid options are only-percentage, message, no-output');
        $command->parse(['bin/coverage-checker', 'clover.xml', '20', '--formatter=test']);
    }

    public function testItShouldThrowWhenInvalidProcessor(): void
    {
        $command = CoverageCheckerCommand::create();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Invalid processor "test". Valid options are clover-coverage');
        $command->parse(['bin/coverage-checker', 'clover.xml', '20', '--processor=test']);
    }
}
