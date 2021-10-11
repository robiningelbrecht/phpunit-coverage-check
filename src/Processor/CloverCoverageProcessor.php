<?php

namespace PHPUnitCoverageChecker\Processor;

use PHPUnitCoverageChecker\Metric;
use PHPUnitCoverageChecker\Metrics;

class CloverCoverageProcessor implements Processor
{
    private const XPATH_METRICS = '//metrics';

    public function getMetrics(string $file): Metrics
    {
        $xml = new \SimpleXMLElement(file_get_contents($file));

        $counts = [
            'elements' => 0,
            'coveredElements' => 0,
            'statements' => 0,
            'coveredStatements' => 0,
            'methods' => 0,
            'coveredMethods' => 0,
        ];

        foreach ($xml->xpath(self::XPATH_METRICS) as $metric) {
            $counts['elements'] += (int)$metric['elements'];
            $counts['coveredElements'] += (int)$metric['coveredelements'];
            $counts['statements'] += (int)$metric['statements'];
            $counts['coveredStatements'] += (int)$metric['coveredstatements'];
            $counts['methods'] += (int)$metric['methods'];
            $counts['coveredMethods'] += (int)$metric['coveredmethods'];
        }
        return new Metrics(
            new Metric($counts['elements'], $counts['coveredElements']),
            new Metric($counts['statements'], $counts['coveredStatements']),
            new Metric($counts['methods'], $counts['coveredMethods']),
        );
    }

}