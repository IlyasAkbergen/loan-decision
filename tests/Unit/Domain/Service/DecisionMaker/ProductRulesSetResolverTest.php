<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Service\DecisionMaker;

use App\Domain\Enum\ProductCode;
use App\Domain\Enum\RuleCode;
use App\Domain\Service\DecisionMaker\ProductRulesSetResolver;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ProductRulesSetResolverTest extends TestCase
{
    public static function provideProductRulesSet(): array
    {
        return [
            'personal loan' => [
                ProductCode::PERSONAL_LOAN,
                [
                    RuleCode::CREDIT_RATING,
                    RuleCode::INCOME,
                    RuleCode::AGE,
                    RuleCode::STATE_EXCLUSIVE,
                    RuleCode::STATE_NY_RANDOM,
                    RuleCode::STATE_CA_INTEREST_INCREASE,
                ],
            ],
        ];
    }

    #[dataProvider('provideProductRulesSet')]
    public function test(
        ProductCode $productCode,
        array $expected,
    ): void {
        $this->assertEquals(
            $expected,
            (new ProductRulesSetResolver())->resolve($productCode),
        );
    }
}
