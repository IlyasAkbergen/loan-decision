<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Service\DecisionMaker\Rule;

use App\Domain\Repository\DecisionMakerRuleRepositoryInterface;
use App\Domain\Service\DecisionMaker\DecisionMaker;
use App\Domain\Service\DecisionMaker\ProductRulesSetResolver;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class BaseRuleTestCase extends TestCase
{
    /**
     * @throws Exception
     */
    protected function getDecisionMaker(
        DecisionMakerRuleRepositoryInterface $decisionMakerRuleRepository = null,
        ProductRulesSetResolver $productRulesSetResolver = null,
    ): DecisionMaker {
        $decisionMakerRuleRepository = $decisionMakerRuleRepository ?? $this->createMock(
            DecisionMakerRuleRepositoryInterface::class,
        );
        $productRulesSetResolver = $productRulesSetResolver ?? $this->createMock(
            ProductRulesSetResolver::class,
        );

        return new DecisionMaker(
            $decisionMakerRuleRepository,
            $productRulesSetResolver,
        );
    }
}
