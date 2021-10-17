<?php

namespace Tests\Formatter;

use PHPUnit\Framework\TestCase;
use PHPUnitCoverageChecker\Formatter\NoOutputFormatter;

class NoOutputFormatterTest extends TestCase
{
    public function testItFormats(): void
    {
        $formatter = new NoOutputFormatter();

        $this->assertEmpty($formatter->formatSuccessMessage(100, 20));
        $this->assertEmpty($formatter->formatErrorMessage(100, 20));
    }
}
