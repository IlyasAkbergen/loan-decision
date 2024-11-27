<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Domain\Enum\RuleCode;
use App\Domain\Service\DecisionMaker\Rule\CreditRatingRule;
use App\Domain\Service\DecisionMaker\Rule\IncomeRule;
use App\Service\DecisionMakerRuleRegistry;
use PHPUnit\Framework\TestCase;

class DecisionMakerRuleRegistryTest extends TestCase
{
    public function testItReturnsCorrectRule(): void
    {
        $decisionMakerRuleRegistry = new DecisionMakerRuleRegistry();
        $decisionMakerRuleRegistry->addRule(new CreditRatingRule());
        $decisionMakerRuleRegistry->addRule(new IncomeRule());

        $actualRules = $decisionMakerRuleRegistry->getRulesByCodes(
            RuleCode::CREDIT_RATING,
            RuleCode::INCOME,
        );
        self::assertEquals(
            [
                new CreditRatingRule(),
                new IncomeRule(),
            ],
            $actualRules,
        );

        $actualRules = $decisionMakerRuleRegistry->getRulesByCodes(RuleCode::INCOME);
        self::assertEquals(
            [
                new IncomeRule(),
            ],
            $actualRules,
        );

        self::expectException(\RuntimeException::class);
        self::expectExceptionMessage('Rule with code state_ny_random not found');
        $decisionMakerRuleRegistry->getRulesByCodes(RuleCode::STATE_NY_RANDOM, RuleCode::CREDIT_RATING);
    }
}
