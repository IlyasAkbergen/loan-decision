<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

readonly class InterestRate
{
    public function __construct(
        public float $value,
    ) {
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
