<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Service\DecisionMaker\Rule;

use App\Domain\Entity\Client;
use App\Domain\Entity\Product;
use App\Domain\Enum\Decision;
use App\Domain\Enum\ProductCode;
use App\Domain\Repository\DecisionMakerRuleRepositoryInterface;
use App\Domain\Service\DecisionMaker\Rule\StateNewYorkRandomRule;
use App\Domain\Service\RandomValueProviderInterface;
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

class StateNewYorkRandomRuleTest extends BaseRuleTest
{
    /**
     * @throws Exception
     */
    public function testShouldDenyWhenRandomIsTrue(): void
    {
        $rule = $this->getRule(true);
        $ruleRepository = $this->createMock(DecisionMakerRuleRepositoryInterface::class);
        $ruleRepository
            ->expects(self::once())
            ->method('getRulesByCodes')
            ->willReturn([$rule]);
        $decisionMaker = $this->getDecisionMaker(
            decisionMakerRuleRepository: $ruleRepository,
        );

        $client = $this->getClient();
        $product = $this->getProduct();
        $loanDecision = $decisionMaker->decide($client, $product);

        self::assertEquals(Decision::DENIED, $loanDecision->getDecision());
    }

    /**
     * @throws Exception
     */
    public function testShouldApproveWhenRandomIsFalse(): void
    {
        $rule = $this->getRule(false);
        $ruleRepository = $this->createMock(DecisionMakerRuleRepositoryInterface::class);
        $ruleRepository
            ->expects(self::once())
            ->method('getRulesByCodes')
            ->willReturn([$rule]);
        $decisionMaker = $this->getDecisionMaker(
            decisionMakerRuleRepository: $ruleRepository,
        );

        $client = $this->getClient();
        $product = $this->getProduct();
        $loanDecision = $decisionMaker->decide($client, $product);

        self::assertEquals(Decision::APPROVED, $loanDecision->getDecision());

    }

    private function getClient(): Client
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
                'NY',
                '12345'
            ),
            new CreditRating(700),
            new PhoneNumber('+75555555555'),
            Income::fromMonthly(1000),
        );
    }

    private function getProduct(): Product
    {
        return new Product(
            id: Uuid::fromString('f1f1f1f1-f1f1-f1f1-f1f1-f1f1f1f1f1f1'),
            name: 'Test',
            code: ProductCode::PERSONAL_LOAN,
            term: Term::fromMonths(12),
            interestRate: new InterestRate(0.1),
            sum: 12345.67,
        );
    }

    /**
     * @throws Exception
     */
    private function getRule(bool $randomBoolValue): StateNewYorkRandomRule
    {
        $randomValueProviderMock = self::createMock(RandomValueProviderInterface::class);
        $randomValueProviderMock
            ->expects(self::once())
            ->method('getRandomBool')
            ->willReturn($randomBoolValue);

        return new StateNewYorkRandomRule(
            randomValueProvider: $randomValueProviderMock,
        );
    }
}
