<?php

declare(strict_types=1);

namespace App\Domain\Event;

use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;

class LoanCreatedEvent extends DomainEvent
{
    public function __construct(
        public readonly UuidInterface $loanId,
        public readonly UuidInterface $clientId,
        public readonly DateTimeImmutable $createdAt,
    ) {
    }
}
