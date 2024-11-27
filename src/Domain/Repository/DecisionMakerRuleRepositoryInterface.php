<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Enum\RuleCode;
use App\Domain\Service\DecisionMaker\RuleInterface;

interface DecisionMakerRuleRepositoryInterface
{
    /**
     * @return RuleInterface[]
     */
    public function getRulesByCodes(RuleCode ...$ruleCodes): array;
}
