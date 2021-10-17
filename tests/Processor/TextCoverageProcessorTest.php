<?php

namespace Tests\Processor;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PHPUnitCoverageChecker\Processor\TextCoverageProcessor;
use Spatie\Snapshots\MatchesSnapshots;

class TextCoverageProcessorTest extends TestCase
{
    use MatchesSnapshots;

    public function testItShoulThrowOnInvalidMetrics(): void
    {
        $processor = new TextCoverageProcessor();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Invalid metric "invalid-metric" for PHPUnitCoverageChecker\Processor\TextCoverageProcessor. classes, lines, methods allowed'
        );
        $processor->getMetrics('some-file', ['invalid-metric']);
    }

    public function testItShouldReturnMetrics(): void
    {
        $processor = new TextCoverageProcessor();

        $fileLocation = dirname(dirname(__FILE__)).'/assets';
        $metrics = $processor->getMetrics($fileLocation.'/text-coverage.txt');

        $this->assertMatchesJsonSnapshot(json_encode($metrics));
    }

    public function testItShouldReturnMetricsWithRestrictions(): void
    {
        $processor = new TextCoverageProcessor();

        $fileLocation = dirname(dirname(__FILE__)).'/assets';
        $metrics = $processor->getMetrics($fileLocation.'/text-coverage.txt', [TextCoverageProcessor::METRIC_LINES]);

        $this->assertMatchesJsonSnapshot(json_encode($metrics));
    }

    public function testItShouldReturnEmptyMetrics(): void
    {
        $processor = new TextCoverageProcessor();

        $fileLocation = dirname(dirname(__FILE__)).'/assets';
        $metrics = $processor->getMetrics($fileLocation.'/text-coverage-invalid.txt');

        $this->assertMatchesJsonSnapshot(json_encode($metrics));
    }
}
