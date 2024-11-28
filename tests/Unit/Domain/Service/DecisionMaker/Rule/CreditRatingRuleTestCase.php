<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Service\DecisionMaker\Rule;

use App\Domain\Entity\Client;
use App\Domain\Entity\Product;
use App\Domain\Enum\Decision;
use App\Domain\Enum\ProductCode;
use App\Domain\Exception\DomainException;
use App\Domain\Repository\DecisionMakerRuleRepositoryInterface;
use App\Domain\Service\DecisionMaker\Rule\CreditRatingRule;
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

class CreditRatingRuleTestCase extends BaseRuleTestCase
{
    public static function provideClientAndDecision(): array
    {
        return [
            'Rating equals to minimun' => [
                'rating' => 500,
                'decision' => Decision::APPROVED,
            ],
            'Rating greater than minimum' => [
                'rating' => 501,
                'decision' => Decision::APPROVED,
            ],
            'Rating less than minimum' => [
                'rating' => 499,
                'decision' => Decision::DENIED,
            ],
        ];
    }

    /**
     * @throws Exception|DomainException
     */
    #[dataProvider('provideClientAndDecision')]
    public function test(int $rating, Decision $decision): void
    {
        $rule = new CreditRatingRule();
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
            new CreditRating($rating),
            new PhoneNumber('+75555555555'),
            Income::fromMonthly(6000),
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
