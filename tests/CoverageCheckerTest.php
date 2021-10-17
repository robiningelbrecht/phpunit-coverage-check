<?php

namespace Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PHPUnitCoverageChecker\Cli\CoverageCheckerCommand;
use PHPUnitCoverageChecker\CoverageChecker;

class CoverageCheckerTest extends TestCase
{
    public function testItShouldThrowOnInvalidFile(): void
    {
        $command = CoverageCheckerCommand::create();

        $command->parse([
            'bin/coverage-checker',
            'invalid-file.extension',
            '20',
         ]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid input file "invalid-file.extension" provided.');
        CoverageChecker::fromCommand($command);
    }

    public function testItShouldThrowOnInvalidPercentage(): void
    {
        $command = CoverageCheckerCommand::create();

        $command->parse([
            'bin/coverage-checker',
            __DIR__.'/clover.xml',
            'not-numeric',
         ]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid percentage "not-numeric" provided. Provide an integer between 0 - 100');
        CoverageChecker::fromCommand($command);
    }

    public function testItShouldValidate(): void
    {
        $command = CoverageCheckerCommand::create();

        $command->parse([
            'bin/coverage-checker',
            __DIR__.'/clover.xml',
            '20',
            '--formatter=message',
            '--processor=clover-coverage',
            '--exit-on-low-coverage',
         ]);

        $coverageChecker = CoverageChecker::fromCommand($command);
        $this->assertTrue($coverageChecker->validates());
    }
}
