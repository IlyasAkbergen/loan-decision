<?php

declare(strict_types=1);

namespace App\Domain\Service\DecisionMaker;

use App\Domain\Enum\ProductCode;
use App\Domain\Enum\RuleCode;

class ProductRulesSetResolver
{
    /**
     * @return RuleCode[]
     */
    public function resolve(ProductCode $productCode): array
    {
        return match ($productCode) {
            ProductCode::PERSONAL_LOAN => [
                RuleCode::CREDIT_RATING,
                RuleCode::INCOME,
                RuleCode::AGE,
                RuleCode::STATE_EXCLUSIVE,
                RuleCode::STATE_NY_RANDOM,
                RuleCode::STATE_CA_INTEREST_INCREASE,
            ],
        };
    }
}
