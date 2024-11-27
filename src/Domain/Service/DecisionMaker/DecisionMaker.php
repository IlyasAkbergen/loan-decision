<?php

declare(strict_types=1);

namespace App\Domain\Service\DecisionMaker;

use App\Domain\Aggregate\LoanDecision;
use App\Domain\Entity\Client;
use App\Domain\Entity\Product;
use App\Domain\Enum\Decision;
use App\Domain\Repository\DecisionMakerRuleRepositoryInterface;
use App\Domain\ValueObject\LoanConditions;

readonly class DecisionMaker
{
    public function __construct(
        protected DecisionMakerRuleRepositoryInterface $rulesRepository,
        protected ProductRulesSetResolver $productRulesSetResolver,
    ) {
    }

    public function decide(Client $client, Product $product): LoanDecision
    {
        $loanDecision = new LoanDecision(
            client: $client,
            product: $product,
            decision: Decision::APPROVED,
            conditions: new LoanConditions(
                sum: $product->sum,
                term: $product->term,
                interestRate: $product->interestRate,
            ),
        );

        foreach ($this->getRules($product) as $rule) {
            $rule($loanDecision);
            if ($loanDecision->getDecision() === Decision::DENIED) {
                return $loanDecision;
            }
        }

        return $loanDecision;
    }

    /**
     * @return RuleInterface[]
     */
    protected function getRules(Product $product): array
    {
        return $this->rulesRepository->getRulesByCodes(
            ...$this->productRulesSetResolver->resolve($product->code),
        );
    }
}
