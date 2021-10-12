<?php

namespace PHPUnitCoverageChecker;

use PHPUnitCoverageChecker\Formatter\Formatter;
use PHPUnitCoverageChecker\Formatter\FormatterFactory;
use PHPUnitCoverageChecker\Processor\Processor;
use PHPUnitCoverageChecker\Processor\ProcessorFactory;

class CoverageChecker
{
    private string $file;
    private float $minPercentage;
    private Formatter $formatter;
    private Processor $processor;
    /**
     * @var Metric[]
     */
    private array $metrics;
    private string $output;

    private function __construct(
        string $file,
        float $min_percentage,
        Formatter $formatter,
        Processor $processor,
        array $enabled_metrics = [])
    {
        $this->file = $file;
        $this->minPercentage = $min_percentage;
        $this->formatter = $formatter;
        $this->processor = $processor;

        $this->metrics = $this->processor->getMetrics($this->file, $enabled_metrics);
        $this->output = $this->formatOutput();
    }

    private function getActualCoveragePercentage(): float
    {
        $covered_metrics = 0;
        $total_metrics = 0;
        foreach ($this->metrics as $metric) {
            $covered_metrics += $metric->getCovered();
            $total_metrics += $metric->getTotal();
        }

        if (0 === $total_metrics) {
            throw new \Exception('Insufficient data for calculation. Please add more code');
        }

        return $covered_metrics / $total_metrics * 100;
    }

    private function formatOutput(): string
    {
        if ($this->validates()) {
            return $this->formatter->formatSuccessMessage($this->minPercentage, $this->getActualCoveragePercentage());
        }

        return $this->formatter->formatErrorMessage($this->minPercentage, $this->getActualCoveragePercentage());
    }

    public function getOutput(): string
    {
        return $this->output;
    }

    public function validates(): bool
    {
        return $this->getActualCoveragePercentage() >= $this->minPercentage;
    }

    public static function fromScriptArguments(array $arguments, array $options = []): self
    {
        self::guardValidArguments($arguments);

        $options = array_merge([
            'formatter' => FormatterFactory::MESSAGE,
            'processor' => ProcessorFactory::CLOVER_COVERAGE,
        ], $options);

        return new self(
            $arguments[0],
            intval($arguments[1]),
            FormatterFactory::fromString($options['formatter']),
            ProcessorFactory::fromString($options['processor']),
            !empty($options['enabled-metrics']) ? explode(',', $options['enabled-metrics']) : [],
        );
    }

    private static function guardValidArguments(array $arguments): void
    {
        if (empty($arguments[0])) {
            throw new \InvalidArgumentException('Please provide an input file');
        }
        if (!file_exists($arguments[0])) {
            throw new \InvalidArgumentException(sprintf('Invalid input file "%s" provided.', $arguments[1]));
        }

        if (!isset($arguments[1]) || !is_numeric($arguments[1]) || intval($arguments[1]) < 1 || intval($arguments[1]) > 100) {
            throw new \InvalidArgumentException(sprintf('Invalid percentage "%s" provided. Provide an integer between 0 - 100', $arguments[1]));
        }
    }
}
