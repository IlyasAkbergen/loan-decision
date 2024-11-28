<?php

declare(strict_types=1);

namespace App\Domain\Service\DecisionMaker\Rule;

use App\Domain\Aggregate\LoanDecision;
use App\Domain\Enum\RuleCode;
use App\Domain\Service\DecisionMaker\RuleInterface;

class StateExclusiveRule implements RuleInterface
{
    private const EXCLUSIVE_STATES = ['CA', 'NY', 'NV'];

    public function __invoke(LoanDecision $loanDecision): void
    {
        if (!in_array($loanDecision->client->address->state, self::EXCLUSIVE_STATES, true)) {
            $loanDecision->setDenied();
        }
    }

    public function getCode(): RuleCode
    {
        return RuleCode::STATE_EXCLUSIVE;
    }
}
