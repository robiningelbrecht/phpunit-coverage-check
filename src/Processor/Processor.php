<?php

namespace PHPUnitCoverageChecker\Processor;

use PHPUnitCoverageChecker\Metrics;

interface Processor
{
    public function getMetrics(string $file): Metrics;
}