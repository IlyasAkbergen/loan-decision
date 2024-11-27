<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Service\DecisionMaker\Rule;

use App\Domain\Entity\Client;
use App\Domain\Entity\Product;
use App\Domain\Enum\Decision;
use App\Domain\Enum\ProductCode;
use App\Domain\Exception\DomainException;
use App\Domain\Repository\DecisionMakerRuleRepositoryInterface;
use App\Domain\Service\DecisionMaker\Rule\IncomeRule;
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
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\Exception;
use Ramsey\Uuid\Uuid;

class IncomeRuleTest extends BaseRuleTest
{
    public static function provideData(): array
    {
        return [
            'income is less than 1000' => [
                999,
                Decision::DENIED,
            ],
            'income is equal to 1000' => [
                1000,
                Decision::APPROVED,
            ],
            'income is greater than 1000' => [
                1001,
                Decision::APPROVED,
            ],
        ];
    }

    /**
     * @throws Exception
     * @throws DomainException
     */
    #[dataProvider('provideData')]
    public function test(float $monthlyIncome, Decision $decision): void
    {
        $rule = new IncomeRule();
        $ruleRepository = $this->createMock(DecisionMakerRuleRepositoryInterface::class);
        $ruleRepository
            ->expects(self::once())
            ->method('getRulesByCodes')
            ->willReturn([$rule]);
        $decisionMaker = $this->getDecisionMaker(
            decisionMakerRuleRepository: $ruleRepository,
        );

        $client = new Client(
            Uuid::fromString('f1f1f1f1-f1f1-f1f1-f1f1-f1f1f1f1f1f1'),
            new FullName('John', 'Doe'),
            new Email('test@test.com'),
            new DateOfBirth(new \DateTimeImmutable('1990-01-01')),
            new SSN('123-45-6789'),
            new Address(
                '123 Main St',
                'Anytown',
                'AS',
                '12345'
            ),
            new CreditRating(700),
            new PhoneNumber('+75555555555'),
            Income::fromMonthly($monthlyIncome),
        );
        $product = new Product(
            id: Uuid::fromString('f1f1f1f1-f1f1-f1f1-f1f1-f1f1f1f1f1f1'),
            name: 'Test',
            code: ProductCode::PERSONAL_LOAN,
            term: Term::fromMonths(12),
            interestRate: new InterestRate(0.1),
            sum: 12345.67,
        );
        $loanDecision = $decisionMaker->decide($client, $product);

        self::assertEquals($decision, $loanDecision->getDecision());
    }
}
