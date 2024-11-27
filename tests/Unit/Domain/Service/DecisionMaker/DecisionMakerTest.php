<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Service\DecisionMaker;

use App\Domain\Aggregate\LoanDecision;
use App\Domain\Entity\Client;
use App\Domain\Entity\Product;
use App\Domain\Enum\Decision;
use App\Domain\Enum\ProductCode;
use App\Domain\Repository\DecisionMakerRuleRepositoryInterface;
use App\Domain\Service\DecisionMaker\DecisionMaker;
use App\Domain\Service\DecisionMaker\ProductRulesSetResolver;
use App\Domain\Service\DecisionMaker\RuleInterface;
use App\Domain\ValueObject\InterestRate;
use App\Domain\ValueObject\LoanConditions;
use App\Domain\ValueObject\Term;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DecisionMakerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testDenyDecision(): void
    {
        $rule = $this->createMock(RuleInterface::class);
        $rule->expects(self::once())
             ->method('__invoke')
             ->willReturnCallback(function (LoanDecision $loanDecision): void {
                 $loanDecision->changeDecision(Decision::DENIED);
             });
        $ruleRepository = $this->createMock(DecisionMakerRuleRepositoryInterface::class);
        $ruleRepository
            ->expects(self::once())
            ->method('getRulesByCodes')
            ->willReturn([$rule]);
        $decisionMaker = $this->getInstance(decisionMakerRuleRepository: $ruleRepository);
        $client = $this->createMock(Client::class);
        $product = new Product(
            id: Uuid::fromString('f1f1f1f1-f1f1-f1f1-f1f1-f1f1f1f1f1f1'),
            name: 'Test',
            code: ProductCode::PERSONAL_LOAN,
            term: Term::fromMonths(12),
            interestRate: new InterestRate(0.1),
            sum: 12345.67,
        );

        self::assertEquals(
            Decision::DENIED,
            $decisionMaker->decide($client, $product)->getDecision(),
        );
    }

    /**
     * @throws Exception
     */
    public function testApprovedWithChanges(): void
    {
        $rule = $this->createMock(RuleInterface::class);
        $rule->expects(self::once())
             ->method('__invoke')
             ->willReturnCallback(function (LoanDecision $loanDecision): void {
                 $loanDecision->changeDecision(Decision::APPROVED_WITH_CHANGES);
                 $loanDecision->conditions = new LoanConditions(
                     sum: 321,
                     term: Term::fromMonths(24),
                     interestRate: new InterestRate(5.5),
                 );
             });$ruleRepository = $this->createMock(DecisionMakerRuleRepositoryInterface::class);
        $ruleRepository
            ->expects(self::once())
            ->method('getRulesByCodes')
            ->willReturn([$rule]);
        $decisionMaker = $this->getInstance(decisionMakerRuleRepository: $ruleRepository);
        $client = $this->createMock(Client::class);
        $product = new Product(
            id: Uuid::fromString('f1f1f1f1-f1f1-f1f1-f1f1-f1f1f1f1f1f1'),
            name: 'Test',
            code: ProductCode::PERSONAL_LOAN,
            term: Term::fromMonths(12),
            interestRate: new InterestRate(0.1),
            sum: 12345.67,
        );

        $loanDecision = $decisionMaker->decide($client, $product);
        self::assertEquals(
            Decision::APPROVED_WITH_CHANGES,
            $loanDecision->getDecision(),
        );
        self::assertEquals(
            new LoanConditions(
                sum: 321,
                term: Term::fromMonths(24),
                interestRate: new InterestRate(5.5),
            ),
            $loanDecision->conditions,
        );
    }

    /**
     * @throws Exception
     */
    public function testApprovedDecision(): void
    {
        $rule = $this->createMock(RuleInterface::class);
        $rule->expects(self::once())
             ->method('__invoke')
             ->willReturnCallback(static fn (LoanDecision $loanDecision) => null);
        $ruleRepository = $this->createMock(DecisionMakerRuleRepositoryInterface::class);
        $ruleRepository
            ->expects(self::once())
            ->method('getRulesByCodes')
            ->willReturn([$rule]);
        $decisionMaker = $this->getInstance(decisionMakerRuleRepository: $ruleRepository);
        $client = $this->createMock(Client::class);
        $product = new Product(
            id: Uuid::fromString('f1f1f1f1-f1f1-f1f1-f1f1-f1f1f1f1f1f1'),
            name: 'Test',
            code: ProductCode::PERSONAL_LOAN,
            term: Term::fromMonths(12),
            interestRate: new InterestRate(0.1),
            sum: 12345.67,
        );

        $loanDecision = $decisionMaker->decide($client, $product);
        self::assertEquals(
            Decision::APPROVED,
            $loanDecision->getDecision(),
        );
        self::assertEquals(
            new LoanConditions(
                sum: 12345.67,
                term: Term::fromMonths(12),
                interestRate: new InterestRate(0.1),
            ),
            $loanDecision->conditions,
        );
    }

    /**
     * @throws Exception
     */
    private function getInstance(
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
