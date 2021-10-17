<?php

namespace PHPUnitCoverageChecker;

use JsonSerializable;

class Metric implements JsonSerializable
{
    private float $total;
    private float $covered;

    public function __construct(float $total, float $covered)
    {
        $this->total = $total;
        $this->covered = $covered;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function getCovered(): float
    {
        return $this->covered;
    }

    public function jsonSerialize(): array
    {
        return [
            'total' => $this->getTotal(),
            'covered' => $this->getCovered(),
        ];
    }
}
