<?php

declare(strict_types=1);

namespace App\Domain\Service\DecisionMaker\Rule;

use App\Domain\Aggregate\LoanDecision;
use App\Domain\Enum\RuleCode;
use App\Domain\Service\DecisionMaker\RuleInterface;

class AgeRule implements RuleInterface
{
    private const MIN_AGE = 18;
    private const MAX_AGE = 60;

    public function __invoke(LoanDecision $loanDecision): void
    {
        $age = $loanDecision->client->dateOfBirth->getAge();
        if ($age < self::MIN_AGE || $age > self::MAX_AGE) {
            $loanDecision->setDenied();
        }
    }

    public function getCode(): RuleCode
    {
        return RuleCode::AGE;
    }
}
