<?php

namespace Tests\Formatter;

use PHPUnit\Framework\TestCase;
use PHPUnitCoverageChecker\Formatter\MessageFormatter;

class MessageFormatterTest extends TestCase
{
    public function testItFormats(): void
    {
        $formatter = new MessageFormatter();

        $this->assertEquals('20.00% test coverage (min required is 100.00%), give yourself a pat on the back', $formatter->formatSuccessMessage(100, 20));
        $this->assertEquals('Expected 100.00% test coverage, got 20.00%', $formatter->formatErrorMessage(100, 20));
    }
}
