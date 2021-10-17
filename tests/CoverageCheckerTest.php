<?php

namespace Tests;

use Exception;
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
            __DIR__.'/assets/clover.xml',
            'not-numeric',
         ]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid percentage "not-numeric" provided. Provide an integer between 0 - 100');
        CoverageChecker::fromCommand($command);
    }

    public function testItShouldThrowOnEmptyMetrics(): void
    {
        $command = CoverageCheckerCommand::create();

        $command->parse([
            'bin/coverage-checker',
            __DIR__.'/assets/clover-empty.xml',
            '20',
            '--formatter=message',
            '--processor=clover-coverage',
            '--exit-on-low-coverage',
         ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Insufficient data for calculation. Please add more code');
        $coverageChecker = CoverageChecker::fromCommand($command);
    }

    public function testItShouldValidate(): void
    {
        $command = CoverageCheckerCommand::create();

        $command->parse([
            'bin/coverage-checker',
            __DIR__.'/assets/clover.xml',
            '20',
            '--formatter=message',
            '--processor=clover-coverage',
            '--exit-on-low-coverage',
         ]);

        $coverageChecker = CoverageChecker::fromCommand($command);
        $this->assertTrue($coverageChecker->validates());
        $this->assertEquals('90.32% test coverage (min required is 20.00%), give yourself a pat on the back', $coverageChecker->getOutput());
    }

    public function testItShouldNotValidate(): void
    {
        $command = CoverageCheckerCommand::create();

        $command->parse([
            'bin/coverage-checker',
            __DIR__.'/assets/clover.xml',
            '100',
            '--formatter=message',
            '--processor=clover-coverage',
            '--exit-on-low-coverage',
         ]);

        $coverageChecker = CoverageChecker::fromCommand($command);
        $this->assertFalse($coverageChecker->validates());
        $this->assertEquals('Expected 100.00% test coverage, got 90.32%', $coverageChecker->getOutput());
    }
}
