<?php

namespace PHPUnitCoverageChecker;

class Metrics
{
    private Metric $classes;
    private Metric $methods;
    private Metric $lines;

    public function __construct(
        Metric $classes,
        Metric $methods,
        Metric $lines)
    {
        $this->classes = $classes;
        $this->methods = $methods;
        $this->lines = $lines;
    }

    public function getClasses(): Metric
    {
        return $this->classes;
    }

    public function getMethods(): Metric
    {
        return $this->methods;
    }

    public function getLines(): Metric
    {
        return $this->lines;
    }

}