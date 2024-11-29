<?php

declare(strict_types=1);

namespace App\Dto\Response;

use App\Domain\Entity\Loan;

readonly class CreateLoanResponse
{
    public function __construct(
        public ?Loan $loan = null,
        public ?string $error = null,
    ) {
    }
}
