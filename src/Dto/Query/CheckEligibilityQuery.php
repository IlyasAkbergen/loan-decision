<?php

declare(strict_types=1);

namespace App\Dto\Query;

use Ramsey\Uuid\UuidInterface;

readonly class CheckEligibilityQuery
{
    public function __construct(
        public UuidInterface $clientId,
        public UuidInterface $productId,
    ) {
    }
}
