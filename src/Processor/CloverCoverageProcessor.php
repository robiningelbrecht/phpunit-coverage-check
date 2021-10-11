<?php

namespace PHPUnitCoverageChecker\Processor;

use PHPUnitCoverageChecker\Metric;
use PHPUnitCoverageChecker\Metrics;

class CloverCoverageProcessor implements Processor
{
    public function getMetrics(): Metrics
    {
        return new Metrics(
            new Metric(100, 90),
            new Metric(100, 90),
            new Metric(100, 90),
        );
    }

}