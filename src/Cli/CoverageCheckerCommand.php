<?php

namespace PHPUnitCoverageChecker\Cli;

use Ahc\Cli\Input\Command;
use PHPUnitCoverageChecker\Formatter\FormatterType;
use PHPUnitCoverageChecker\Processor\ProcessorType;
use RuntimeException;

class CoverageCheckerCommand extends Command
{
    private const version = '1.0';

    public function getArgumentValues(): array
    {
        $values = $this->values();

        return [
            (string) Argument::file() => $values[(string) Argument::file()],
            (string) Argument::percentage() => $values[(string) Argument::percentage()],
        ];
    }

    public function getOptionValues(): array
    {
        $values = $this->values(false);
        unset($values[(string) Argument::file()], $values[(string) Argument::percentage()]);

        return $values;
    }

    protected function validate(): void
    {
        parent::validate();
        $this->guardValidOptions();
    }

    private function guardValidOptions(): void
    {
        $options = $this->getOptionValues();

        if (!in_array($options[(string) Option::formatter()], FormatterType::toArray())) {
            throw new RuntimeException(sprintf('Invalid formatter "%s". Valid options are %s', $options[(string) Option::formatter()], implode(', ', FormatterType::toArray())));
        }

        if (!in_array($options[(string) Option::processor()], ProcessorType::toArray())) {
            throw new RuntimeException(sprintf('Invalid processor "%s". Valid options are %s', $options[(string) Option::processor()], implode(', ', ProcessorType::toArray())));
        }
    }

    public static function create(): self
    {
        $command = new self(
            'coverage-checker',
            'Check the code coverage using the clover or text report of phpunit'
        );

        $command
            ->version(self::version)
            ->arguments('<file> <percentage>')
            ->option('-p --processor', sprintf('Processor to use ("%s" by default)', ProcessorType::cloverCoverage()), null, ProcessorType::cloverCoverage())
            ->option('-f --formatter', sprintf('Formatter to use ("%s" by default)', FormatterType::message()), null, FormatterType::message())
            ->option('-elc --exit-on-low-coverage', 'Exit the script when low coverage is detected. Defaults to "false"', null, false)
            ->option('-m --enabled-metrics', 'Metrics to use when calculating coverage. Defaults to all');

        return $command;
    }
}
