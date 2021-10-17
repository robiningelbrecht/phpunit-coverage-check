<?php

namespace PHPUnitCoverageChecker\Processor;

use PHPUnitCoverageChecker\Metric;

class TextCoverageProcessor implements Processor
{
    public const METRIC_CLASSES = 'classes';
    public const METRIC_LINES = 'lines';
    public const METRIC_METHODS = 'methods';

    private const DEFAULT_METRICS = [
        self::METRIC_CLASSES,
        self::METRIC_LINES,
        self::METRIC_METHODS,
    ];

    public function getMetrics(string $file, array $enabled_metrics = []): array
    {
        $enabled_metrics = $enabled_metrics ?: self::DEFAULT_METRICS;
        $this->guardValidEnabledMetrics($enabled_metrics);

        $content = file_get_contents($file);

        $counts = [];
        foreach ($enabled_metrics as $enabled_metric) {
            $matches = [];
            if (!preg_match('/'.$enabled_metric.':(?<'.$enabled_metric.'>.*)%/mi', $content, $matches)) {
                return [];
            }
            $counts[$enabled_metric] = [
                'total' => 100,
                'covered' => (float) rtrim(trim($matches[$enabled_metric])),
            ];
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
