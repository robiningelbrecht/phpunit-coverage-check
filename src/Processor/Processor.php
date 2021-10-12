<?php

namespace PHPUnitCoverageChecker\Processor;

interface Processor
{
    public function getMetrics(string $file, array $enabled_metrics = []): array;
}
