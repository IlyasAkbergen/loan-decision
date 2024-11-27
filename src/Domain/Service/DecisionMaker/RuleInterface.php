<?php

declare(strict_types=1);

namespace App\Domain\Service\DecisionMaker;

use App\Domain\Aggregate\LoanDecision;
use App\Domain\Enum\RuleCode;

interface RuleInterface
{
    public function __invoke(LoanDecision $loanDecision): void;

    public function getCode(): RuleCode;
}
