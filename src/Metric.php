<?php

namespace PHPUnitCoverageChecker;

use JsonSerializable;

class Metric implements JsonSerializable
{
    private int $total;
    private int $covered;

    public function __construct(int $total, int $covered)
    {
        $this->total = $total;
        $this->covered = $covered;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getCovered(): int
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
