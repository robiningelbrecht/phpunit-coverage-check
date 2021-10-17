<?php

namespace Tests\Processor;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PHPUnitCoverageChecker\Processor\Processor;
use PHPUnitCoverageChecker\Processor\ProcessorFactory;

class ProcessorFactoryTest extends TestCase{

    public function testItShouldThrowOnInvalidArg(): void{
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid processor "invalid". clover-coverage allowed');
       
        ProcessorFactory::fromString('invalid');
    }

    public function testItShouldReturn() : void{
        $processor = ProcessorFactory::fromString(ProcessorFactory::CLOVER_COVERAGE);

        $this->assertInstanceOf(Processor::class, $processor);
    }
}