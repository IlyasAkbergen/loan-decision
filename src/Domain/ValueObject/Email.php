<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\InvalidEmailException;

readonly class Email
{
    /**
     * @throws InvalidEmailException
     */
    public function __construct(
        public string $value,
    ) {
        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException($this->value);
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
