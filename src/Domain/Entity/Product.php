<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Enum\ProductCode;
use App\Domain\ValueObject\InterestRate;
use App\Domain\ValueObject\Term;
use Ramsey\Uuid\UuidInterface;

class Product
{
    public function __construct(
        public readonly UuidInterface $id,
        public readonly string $name,
        public readonly ProductCode $code,
        public readonly Term $term,
        public readonly InterestRate $interestRate,
        public readonly float $sum,
    ) {
    }
}
