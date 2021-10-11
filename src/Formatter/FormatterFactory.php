<?php

namespace PHPUnitCoverageChecker\Formatter;

abstract class FormatterFactory
{
    public const ONLY_PERCENTAGE = 'only-percentage';
    private const ALL = [
        self::ONLY_PERCENTAGE,
    ];

    public static function fromString(string $string): Formatter
    {
        if ($string === self::ONLY_PERCENTAGE) {
            return new OnlyPercentageFormatter();
        }

        throw new \InvalidArgumentException(sprintf('Invalid formatter "%s". %s allowed', $string, implode(',',self::ALL)));
    }
}