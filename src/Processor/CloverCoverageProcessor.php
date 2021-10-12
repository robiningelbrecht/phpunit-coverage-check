<?php

namespace PHPUnitCoverageChecker\Processor;

use PHPUnitCoverageChecker\Metric;

class CloverCoverageProcessor implements Processor
{
    private const XPATH_METRICS = '//metrics';

    private const METRIC_ELEMENTS = 'elements';
    private const METRIC_STATEMENTS = 'statements';
    private const METRIC_METHODS = 'methods';

    private const DEFAULT_METRICS = [
        self::METRIC_ELEMENTS,
        self::METRIC_STATEMENTS,
        self::METRIC_METHODS,
    ];

    public function getMetrics(string $file, array $enabled_metrics = []): array
    {
        $enabled_metrics = $enabled_metrics ?: self::DEFAULT_METRICS;
        $this->guardValidEnabledMetrics($enabled_metrics);

        $xml = new \SimpleXMLElement(file_get_contents($file));

        $counts = [];
        foreach ($xml->xpath(self::XPATH_METRICS) as $metric) {
            if (in_array(self::METRIC_ELEMENTS, $enabled_metrics)) {
                $counts['elements']['total'] += (int) $metric['elements'];
                $counts['elements']['covered'] += (int) $metric['coveredelements'];
            }
            if (in_array(self::METRIC_STATEMENTS, $enabled_metrics)) {
                $counts['statements']['total'] += (int) $metric['statements'];
                $counts['statements']['covered'] += (int) $metric['coveredstatements'];
            }
            if (in_array(self::METRIC_METHODS, $enabled_metrics)) {
                $counts['methods']['total'] += (int) $metric['methods'];
                $counts['methods']['covered'] += (int) $metric['coveredmethods'];
            }
        }

        return array_map(fn (array $count) => new Metric($count['total'], $count['covered']), $counts);
    }

    private function guardValidEnabledMetrics(array $enabled_metrics): void
    {
        foreach ($enabled_metrics as $enabled_metric) {
            if (in_array($enabled_metric, self::DEFAULT_METRICS)) {
                continue;
            }

            throw new \InvalidArgumentException(sprintf('Invalid metric "%s" for %s. %s allowed', $enabled_metric, self::class, implode(', ', self::DEFAULT_METRICS)));
        }
    }
}
