<?php

declare(strict_types=1);

namespace App\Domain\Service\DecisionMaker\Rule;

use App\Domain\Aggregate\LoanDecision;
use App\Domain\Enum\Decision;
use App\Domain\Enum\RuleCode;
use App\Domain\Service\DecisionMaker\RuleInterface;
use App\Domain\ValueObject\InterestRate;

class StateCaliforniaInterestIncreaseRule implements RuleInterface
{
    private const INTEREST_RATE = 11.49;

    public function __invoke(LoanDecision $loanDecision): void
    {
        if ($loanDecision->client->address->state === 'CA') {
            $loanDecision->changeDecision(Decision::APPROVED_WITH_CHANGES);
            $loanDecision->conditions->interestRate = new InterestRate(
                $loanDecision->conditions->interestRate->value + self::INTEREST_RATE,
            );
        }
    }

    public function getCode(): RuleCode
    {
        return RuleCode::STATE_CA_INTEREST_INCREASE;
    }
}
