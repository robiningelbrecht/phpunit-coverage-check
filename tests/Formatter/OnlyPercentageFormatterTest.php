<?php

namespace Tests\Formatter;

use PHPUnit\Framework\TestCase;
use PHPUnitCoverageChecker\Formatter\OnlyPercentageFormatter;

class OnlyPercentageFormatterTest extends TestCase
{
    public function testItFormats(): void
    {
        $formatter = new OnlyPercentageFormatter();

        $this->assertEquals('20.00', $formatter->formatSuccessMessage(100, 20));
        $this->assertEquals('20.00', $formatter->formatErrorMessage(100, 20));
    }
}
