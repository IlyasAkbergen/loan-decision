<?php

declare(strict_types=1);

namespace App\Domain\Service\DecisionMaker\Rule;

use App\Domain\Aggregate\LoanDecision;
use App\Domain\Enum\RuleCode;
use App\Domain\Service\DecisionMaker\RuleInterface;
use App\Domain\Service\RandomValueProviderInterface;

class StateNewYorkRandomRule implements RuleInterface
{
    public function __construct(
        private RandomValueProviderInterface $randomValueProvider,
    ) {
    }

    public function __invoke(LoanDecision $loanDecision): void
    {
        if ($loanDecision->client->address->state === 'NY' && $this->randomValueProvider->getRandomBool()) {
            $loanDecision->setDenied();
        }
    }

    public function getCode(): RuleCode
    {
        return RuleCode::STATE_NY_RANDOM;
    }
}
