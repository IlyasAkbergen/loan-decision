<?php

declare(strict_types=1);

namespace App\Dto\Command;

use DateTimeImmutable;

readonly class CreateClientCommand
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $phone,
        public string $ssn,
        public DateTimeImmutable $dateOfBirth,
        public int $creditRating,
        public float $income,
        public string $street,
        public string $city,
        public string $state,
        public string $zip,
    ) {
    }
}
