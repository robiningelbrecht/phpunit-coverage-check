<?php

namespace PHPUnitCoverageChecker;

use PHPUnitCoverageChecker\Cli\Argument;
use PHPUnitCoverageChecker\Cli\CoverageCheckerCommand;
use PHPUnitCoverageChecker\Cli\Option;
use PHPUnitCoverageChecker\Formatter\Formatter;
use PHPUnitCoverageChecker\Formatter\FormatterFactory;
use PHPUnitCoverageChecker\Formatter\FormatterType;
use PHPUnitCoverageChecker\Processor\Processor;
use PHPUnitCoverageChecker\Processor\ProcessorFactory;
use PHPUnitCoverageChecker\Processor\ProcessorType;

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

    public static function fromCommand(CoverageCheckerCommand $command): self
    {
        $arguments = $command->getArgumentValues();
        self::guardValidArguments($arguments);

        $options = array_merge([
            (string) Option::formatter() => FormatterType::message(),
            (string) Option::processor() => ProcessorType::cloverCoverage(),
        ], $command->getOptionValues());

        return new self(
            $arguments[(string) Argument::file()],
            intval($arguments[(string) Argument::percentage()]),
            FormatterFactory::fromString((string) $options[(string) Option::formatter()]),
            ProcessorFactory::fromString((string) $options[(string) Option::processor()]),
            !empty($options[(string) Option::enabledMetrics()]) ? explode(',', $options[(string) Option::enabledMetrics()]) : [],
        );
    }

    private static function guardValidArguments(array $arguments): void
    {
        if (!file_exists($arguments[(string) Argument::file()])) {
            throw new \InvalidArgumentException(sprintf('Invalid input file "%s" provided.', $arguments[(string) Argument::file()]));
        }

        if (!is_numeric($arguments[(string) Argument::percentage()])
        || intval($arguments[(string) Argument::percentage()]) < 1
        || intval($arguments[(string) Argument::percentage()]) > 100) {
            throw new \InvalidArgumentException(sprintf('Invalid percentage "%s" provided. Provide an integer between 0 - 100', $arguments[(string) Argument::percentage()]));
        }
    }
}
