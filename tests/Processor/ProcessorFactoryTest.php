<?php

namespace Tests\Processor;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PHPUnitCoverageChecker\Processor\CloverCoverageProcessor;
use PHPUnitCoverageChecker\Processor\ProcessorFactory;
use PHPUnitCoverageChecker\Processor\ProcessorType;

class ProcessorFactoryTest extends TestCase
{
    public function testItShouldThrowOnInvalidArg(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid processor "invalid". clover-coverage allowed');

        ProcessorFactory::fromString('invalid');
    }

    public function testItShouldReturn(): void
    {
        $processor = ProcessorFactory::fromString(ProcessorType::cloverCoverage());

        $this->assertInstanceOf(CloverCoverageProcessor::class, $processor);
    }
}
