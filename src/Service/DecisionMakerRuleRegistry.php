<?php

declare(strict_types=1);

namespace App\Service;

use App\Domain\Enum\RuleCode;
use App\Domain\Repository\DecisionMakerRuleRepositoryInterface;
use App\Domain\Service\DecisionMaker\RuleInterface;

class DecisionMakerRuleRegistry implements DecisionMakerRuleRepositoryInterface
{
    /**
     * @var array<string, RuleInterface>
     */
    private array $rules = [];

    /**
     * @param RuleInterface[] $rules
     */
    public function __construct(iterable $rules)
    {
        foreach ($rules as $rule) {
            $this->addRule($rule);
        }
    }

    public function addRule(RuleInterface $rule): void
    {
        $this->rules[$rule->getCode()->value] = $rule;
    }

    /**
     * @return RuleInterface[]
     */
    public function getRulesByCodes(RuleCode ...$ruleCodes): array
    {
        $rules = [];

        foreach ($ruleCodes as $ruleCode) {
            $rules[] = $this->rules[$ruleCode->value] ?? throw new \RuntimeException(
                sprintf('Rule with code %s not found', $ruleCode->value),
            );
        }

        return $rules;
    }
}
