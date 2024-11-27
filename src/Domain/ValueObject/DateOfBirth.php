<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

readonly class DateOfBirth
{
    public function __construct(
        public \DateTimeImmutable $value,
    ) {
    }

    public function __toString(): string
    {
        return $this->value->format('Y-m-d');
    }

    public function getAge(): int
    {
        $now = new \DateTimeImmutable();
        $interval = $this->value->diff($now);

        return $interval->y;
    }
}
