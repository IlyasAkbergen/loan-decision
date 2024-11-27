<?php

declare(strict_types=1);

namespace App\Domain\Service\DecisionMaker\Rule;

use App\Domain\Aggregate\LoanDecision;
use App\Domain\Enum\RuleCode;
use App\Domain\Service\DecisionMaker\RuleInterface;

class CreditRatingRule implements RuleInterface
{
    private const MIN_CREDIT_RATING = 500;

    public function __invoke(LoanDecision $loanDecision): void
    {
        if ($loanDecision->client->creditRating->value < self::MIN_CREDIT_RATING) {
            $loanDecision->setDenied();
        }
    }

    public function getCode(): RuleCode
    {
        return RuleCode::CREDIT_RATING;
    }
}
