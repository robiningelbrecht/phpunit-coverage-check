<?php

namespace PHPUnitCoverageChecker;

use PHPUnitCoverageChecker\Formatter\Formatter;
use PHPUnitCoverageChecker\Formatter\FormatterFactory;
use PHPUnitCoverageChecker\Processor\Processor;
use PHPUnitCoverageChecker\Processor\ProcessorFactory;

class CoverageChecker
{

    private string $file;
    private int $minPercentage;
    private Formatter $formatter;
    private Processor $processor;

    private function __construct(
        string $file,
        int $minPercentage,
        Formatter $formatter,
        Processor $processor)
    {
        $this->file = $file;
        $this->minPercentage = $minPercentage;
        $this->formatter = $formatter;
        $this->processor = $processor;
    }

    public function process(): self{
        return $this;
    }

    public function format(): self{
        return $this;
    }

    public function getOutput(): string{
        return 'test';
    }

    public function validates(): bool{
        return false;
    }

    public static function fromScriptArguments(array $arguments, array $options = []): self
    {
        self::guardValidArguments($arguments);

        $options = array_merge([
            'formatter' => FormatterFactory::ONLY_PERCENTAGE,
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

        if (!isset($arguments[1]) || !is_numeric($arguments[1]) || intval($arguments[1]) < 0 || intval($arguments[1]) > 100) {
            throw new \InvalidArgumentException(sprintf('Invalid percentage "%s" provided. Provide an integer between 0 - 100', $arguments[1]));
        }
    }

}