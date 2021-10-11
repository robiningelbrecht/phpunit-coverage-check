<?php

namespace PHPUnitCoverageChecker;

class Metrics
{
    private Metric $elements;
    private Metric $statements;
    private Metric $methods;

    public function __construct(Metric $elements, Metric $statements, Metric $methods)
    {
        $this->elements = $elements;
        $this->statements = $statements;
        $this->methods = $methods;
    }

    public function getElements(): Metric
    {
        return $this->elements;
    }

    public function getStatements(): Metric
    {
        return $this->statements;
    }

    public function getMethods(): Metric
    {
        return $this->methods;
    }

}