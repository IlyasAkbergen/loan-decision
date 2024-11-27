<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

readonly class FullName
{
    function __construct(
        public string $firstName,
        public string $lastName,
    ) {
    }

    public function __toString(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}
