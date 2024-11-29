<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Dto\Command;

use App\Domain\Enum\MessagingChannel;
use DateTimeImmutable;

readonly class UpdateClientCommand
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
        public MessagingChannel $messagingChannel,
    ) {
    }
}
