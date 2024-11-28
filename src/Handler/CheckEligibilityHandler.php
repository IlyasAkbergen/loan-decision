<?php

declare(strict_types=1);

namespace App\Handler;

use App\Domain\Repository\ClientRepositoryInterface;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Domain\Service\DecisionMaker\DecisionMaker;
use App\Dto\Query\CheckEligibilityQuery;
use App\Dto\Response\CheckEligibilityResponse;

readonly class CheckEligibilityHandler
{
    public function __construct(
        private DecisionMaker $decisionMaker,
        private ClientRepositoryInterface $clientRepository,
        private ProductRepositoryInterface $productRepository,
    ) {
    }

    public function __invoke(CheckEligibilityQuery $query): CheckEligibilityResponse
    {
        $client = $this->clientRepository->findById($query->clientId);
        if ($client === null) {
            return new CheckEligibilityResponse(
                loanDecision: null,
                error: 'Client not found',
            );
        }

        $product = $this->productRepository->findById($query->productId);
        if ($product === null) {
            return new CheckEligibilityResponse(
                loanDecision: null,
                error: 'Product not found',
            );
        }

        $loanDecision = $this->decisionMaker->decide(
            client: $client,
            product: $product,
        );

        return new CheckEligibilityResponse(
            loanDecision: $loanDecision,
            error: null,
        );
    }
}
