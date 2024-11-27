<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class LoanConditions
{
    public function __construct(
        public float $sum,
        public Term $term,
        public InterestRate $interestRate,
    ) {
    }
}
