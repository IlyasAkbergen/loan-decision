<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Service\DecisionMaker\Rule;

use App\Domain\Entity\Client;
use App\Domain\Entity\Product;
use App\Domain\Enum\Decision;
use App\Domain\Enum\ProductCode;
use App\Domain\Repository\DecisionMakerRuleRepositoryInterface;
use App\Domain\Service\DecisionMaker\Rule\StateCaliforniaInterestIncreaseRule;
use App\Domain\ValueObject\Address;
use App\Domain\ValueObject\CreditRating;
use App\Domain\ValueObject\DateOfBirth;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\FullName;
use App\Domain\ValueObject\Income;
use App\Domain\ValueObject\InterestRate;
use App\Domain\ValueObject\PhoneNumber;
use App\Domain\ValueObject\SSN;
use App\Domain\ValueObject\Term;
use PHPUnit\Framework\MockObject\Exception;
use Ramsey\Uuid\Uuid;

class StateCaliforniaInterestIncreaseRuleTestCase extends BaseRuleTestCase
{
    /**
     * @throws Exception
     */
    public function testApply(): void
    {
        $rule = new StateCaliforniaInterestIncreaseRule();
        $ruleRepository = $this->createMock(DecisionMakerRuleRepositoryInterface::class);
        $ruleRepository
            ->expects(self::exactly(2))
            ->method('getRulesByCodes')
            ->willReturn([$rule]);
        $decisionMaker = $this->getDecisionMaker(
            decisionMakerRuleRepository: $ruleRepository,
        );
        $client1 = $this->createClient('CA');
        $product = new Product(
            id: Uuid::fromString('f1f1f1f1-f1f1-f1f1-f1f1-f1f1f1f1f1f1'),
            name: 'Test',
            code: ProductCode::PERSONAL_LOAN,
            term: Term::fromMonths(12),
            interestRate: new InterestRate(5.5),
            sum: 12345.67,
        );
        $loanDecision1 = $decisionMaker->decide($client1, $product);

        self::assertEquals(Decision::APPROVED_WITH_CHANGES, $loanDecision1->getDecision());
        self::assertEquals(5.5 + 11.49, $loanDecision1->conditions->interestRate->value);

        $client2 = $this->createClient('NY');
        $loanDecision2 = $decisionMaker->decide($client2, $product);
        self::assertEquals(Decision::APPROVED, $loanDecision2->getDecision());
        self::assertEquals(5.5, $loanDecision2->conditions->interestRate->value);
    }

    private function createClient(string $state): Client
    {
        return new Client(
            Uuid::fromString('f1f1f1f1-f1f1-f1f1-f1f1-f1f1f1f1f1f1'),
            new FullName('John', 'Doe'),
            new Email('test@test.com'),
            new DateOfBirth(new \DateTimeImmutable('1990-01-01')),
            new SSN('123-45-6789'),
            new Address(
                '123 Main St',
                'Anytown',
                $state,
                '12345'
            ),
            new CreditRating(700),
            new PhoneNumber('+75555555555'),
            Income::fromMonthly(1000),
        );
    }
}
