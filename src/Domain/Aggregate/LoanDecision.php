<?php

declare(strict_types=1);

namespace App\Domain\Aggregate;

use App\Domain\Entity\Client;
use App\Domain\Entity\Product;
use App\Domain\Enum\Decision;
use App\Domain\ValueObject\LoanConditions;

class LoanDecision
{
    public function __construct(
        public readonly Client $client,
        public Product $product,
        private Decision $decision,
        public ?LoanConditions $conditions = null,
    ) {
    }

    public function changeDecision(Decision $decision): void
    {
        if (
            $decision === Decision::APPROVED
            && in_array($this->decision, [Decision::DENIED, Decision::APPROVED_WITH_CHANGES])
        ) {
            throw new \LogicException('Cannot change decision from to APPROVED');
        }

        if ($decision === Decision::APPROVED_WITH_CHANGES && $this->decision === Decision::DENIED) {
            throw new \LogicException('Cannot change decision from APPROVED to APPROVED_WITH_CHANGES');
        }

        $this->decision = $decision;
    }

    public function getDecision(): Decision
    {
        return $this->decision;
    }

    public function setDenied(): void
    {
        $this->changeDecision(Decision::DENIED);
    }
}
