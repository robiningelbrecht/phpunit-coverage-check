<?php

namespace PHPUnitCoverageChecker\Formatter;

abstract class FormatterFactory
{
    public static function fromString(string $string): Formatter
    {
        if (FormatterType::onlyPercentage() == $string) {
            return new OnlyPercentageFormatter();
        }
        if (FormatterType::message() == $string) {
            return new MessageFormatter();
        }
        if (FormatterType::noOutput() == $string) {
            return new NoOutputFormatter();
        }

        throw new \InvalidArgumentException(sprintf('Invalid formatter "%s". %s allowed', $string, implode(',', self::ALL)));
    }
}
