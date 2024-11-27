<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

readonly class Term
{
    public function __construct(
        public int $months,
    ) {
    }

    public static function fromMonths(int $int): self
    {
        return new self(
            months: $int,
        );
    }

    public function __toString(): string
    {
        return (string) $this->months;
    }
}
