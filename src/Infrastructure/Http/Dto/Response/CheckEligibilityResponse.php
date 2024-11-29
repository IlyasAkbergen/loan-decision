<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Dto\Response;

use App\Domain\Aggregate\LoanDecision;

readonly class CheckEligibilityResponse
{
    public function __construct(
        public ?LoanDecision $loanDecision = null,
        public ?string $error = null,
    ) {
    }
}
