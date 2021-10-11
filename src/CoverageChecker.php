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
    private Metrics $metrics;
    private string $output;

    private function __construct(
        string $file,
        float $minPercentage,
        Formatter $formatter,
        Processor $processor)
    {
        $this->file = $file;
        $this->minPercentage = $minPercentage;
        $this->formatter = $formatter;
        $this->processor = $processor;

        $this->metrics = $this->getMetrics();
        $this->output = $this->formatOutput();
    }

    private function getActualCoveragePercentage(): float
    {
        $covered_metrics = $this->metrics->getElements()->getCovered()
            + $this->metrics->getMethods()->getCovered()
            + $this->metrics->getStatements()->getCovered();

        $total_metrics = $this->metrics->getElements()->getTotal()
            + $this->metrics->getMethods()->getTotal()
            + $this->metrics->getStatements()->getTotal();

        if ($total_metrics === 0) {
            throw new \Exception('Insufficient data for calculation. Please add more code');
        }


        return $covered_metrics / $total_metrics * 100;
    }

    private function getMetrics(): Metrics
    {
        return $this->processor->getMetrics($this->file);
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
            ProcessorFactory::fromString($options['processor'])
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