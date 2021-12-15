<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class CliScriptTest extends TestCase
{
    public function testItShouldExitWithError(): void
    {
        $output = shell_exec(dirname(dirname(__FILE__)).'/bin/coverage-checker '.__DIR__.'/assets/clover.xml 100 --exit-on-low-coverage=1');
        $this->assertTrue($this->endsWith($output, '1'));
    }

    public function testItShouldExitWithoutError(): void
    {
        $output = shell_exec(dirname(dirname(__FILE__)).'/bin/coverage-checker '.__DIR__.'/assets/clover.xml 100 --exit-on-low-coverage=0');
        $this->assertFalse($this->endsWith($output, '0'));
    }

    private function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if (!$length) {
            return true;
        }

        return substr($haystack, -$length) === $needle;
    }
}
