<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\LoanConditions;
use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;

class Loan
{
    public function __construct(
        public readonly UuidInterface $id,
        public readonly Client $client,
        public readonly Product $product,
        public readonly LoanConditions $conditions,
        public readonly DateTimeImmutable $createdAt,
    ) {
    }
}
