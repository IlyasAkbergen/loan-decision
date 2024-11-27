<?php

declare(strict_types=1);

namespace App\Domain\Service\DecisionMaker\Rule;

use App\Domain\Aggregate\LoanDecision;
use App\Domain\Enum\RuleCode;
use App\Domain\Service\DecisionMaker\RuleInterface;

class IncomeRule implements RuleInterface
{
    const MIN_INCOME = 1000;

    public function __invoke(LoanDecision $loanDecision): void
    {
        if ($loanDecision->client->income->monthly < self::MIN_INCOME) {
            $loanDecision->setDenied();
        }
    }

    public function getCode(): RuleCode
    {
        return RuleCode::INCOME;
    }
}
