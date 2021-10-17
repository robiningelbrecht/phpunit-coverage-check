<?php

namespace Tests\Formatter;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PHPUnitCoverageChecker\Formatter\FormatterFactory;
use PHPUnitCoverageChecker\Formatter\FormatterType;
use PHPUnitCoverageChecker\Formatter\MessageFormatter;
use PHPUnitCoverageChecker\Formatter\NoOutputFormatter;
use PHPUnitCoverageChecker\Formatter\OnlyPercentageFormatter;

class FormatterFactoryTest extends TestCase
{
    public function testItShouldThrowOnInvalidArg(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid formatter "invalid". only-percentage, message, no-output allowed');

        FormatterFactory::fromString('invalid');
    }

    public function testItShouldReturn(): void
    {
        $formatter = FormatterFactory::fromString(FormatterType::message());
        $this->assertInstanceOf(MessageFormatter::class, $formatter);

        $formatter = FormatterFactory::fromString(FormatterType::onlyPercentage());
        $this->assertInstanceOf(OnlyPercentageFormatter::class, $formatter);

        $formatter = FormatterFactory::fromString(FormatterType::noOutput());
        $this->assertInstanceOf(NoOutputFormatter::class, $formatter);
    }
}
