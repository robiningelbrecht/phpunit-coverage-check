<?php

namespace Tests\Processor;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PHPUnitCoverageChecker\Processor\CloverCoverageProcessor;
use Spatie\Snapshots\MatchesSnapshots;

class CloverCoverageProcessorTest extends TestCase
{
    use MatchesSnapshots;

    public function testItShoulThrowOnInvalidMetrics(): void
    {
        $processor = new CloverCoverageProcessor();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Invalid metric "invalid-metric" for PHPUnitCoverageChecker\Processor\CloverCoverageProcessor. elements, statements, methods allowed'
        );
        $processor->getMetrics('some-file', ['invalid-metric']);
    }

    public function testItShouldReturnMetrics(): void
    {
        $processor = new CloverCoverageProcessor();

        $fileLocation = dirname(dirname(__FILE__));
        $metrics = $processor->getMetrics($fileLocation.'/clover.xml');

        $this->assertMatchesJsonSnapshot(json_encode($metrics));
    }

    public function testItShouldReturnMetricsWithRestrictions(): void
    {
        $processor = new CloverCoverageProcessor();

        $fileLocation = dirname(dirname(__FILE__));
        $metrics = $processor->getMetrics($fileLocation.'/clover.xml', [CloverCoverageProcessor::METRIC_ELEMENTS]);

        $this->assertMatchesJsonSnapshot(json_encode($metrics));
    }
}
