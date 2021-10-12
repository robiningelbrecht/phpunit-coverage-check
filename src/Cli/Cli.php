<?php

namespace PHPUnitCoverageChecker\Cli;

class Cli
{
    private array $argv;
    private CliColors $colors;

    public function __construct(CliColors $colors)
    {
        array_shift($_SERVER['argv']);
        $this->argv = $_SERVER['argv'];
        $this->colors = $colors;
    }

    public function getArguments(): array
    {
        return array_filter($this->argv, fn (string $argument) => 0 !== strpos($argument, '--'));
    }

    public function getOptions(): array
    {
        $options = [];
        $unformatted_options = array_filter($this->argv, fn (string $argument) => 0 === strpos($argument, '--'));

        foreach ($unformatted_options as $option) {
            [$key, $value] = explode('=', substr($option, 2));
            $options[$key] = $value;
        }

        return $options;
    }

    public function output(string $string, string $foregroundColor = null, string $backgroundColor = null): void
    {
        echo $this->colors->getColoredString($string, $foregroundColor, $backgroundColor);
    }

    public function error(string $string): void
    {
        $this->output($string, 'red');
    }

    public function success(string $string): void
    {
        $this->output($string, 'green');
    }
}
