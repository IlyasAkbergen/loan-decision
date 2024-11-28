<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

readonly class Income
{
    public function __construct(
        public float $monthly,
        public float $annual,
    ) {
    }

    public static function fromMonthly(float $monthly): self
    {
        return new self(
            monthly: $monthly,
            annual: $monthly * 12,
        );
    }

    public static function fromAnnual(float $annual): self
    {
        return new self(
            monthly: $annual / 12,
            annual: $annual,
        );
    }

    public function __toString(): string
    {
        return number_format($this->monthly, 2);
    }
}
