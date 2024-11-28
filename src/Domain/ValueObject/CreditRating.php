<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\DomainException;

readonly class CreditRating
{
    private const MIN_VALUE = 300;
    private const MAX_VALUE = 850;

    /**
     * @throws DomainException
     */
    public function __construct(
        public int $value,
    ) {
        if ($this->value < self::MIN_VALUE || $this->value > self::MAX_VALUE) {
            throw new DomainException('Credit rating must be between 300 and 850. Got: ' . $this->value);
        }
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
