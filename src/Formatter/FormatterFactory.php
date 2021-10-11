<?php

namespace PHPUnitCoverageChecker\Formatter;

abstract class FormatterFactory
{
    public const ONLY_PERCENTAGE = 'only-percentage';
    public const MESSAGE = 'message';
    private const ALL = [
        self::ONLY_PERCENTAGE,
        self::MESSAGE,
    ];

    public static function fromString(string $string): Formatter
    {
        if ($string === self::ONLY_PERCENTAGE) {
            return new OnlyPercentageFormatter();
        }
        if ($string === self::MESSAGE) {
            return new MessageFormatter();
        }

        throw new \InvalidArgumentException(sprintf('Invalid formatter "%s". %s allowed', $string, implode(',',self::ALL)));
    }
}