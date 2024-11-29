<?php

declare(strict_types=1);

namespace App\Dto\Command;

use Ramsey\Uuid\UuidInterface;

readonly class CreateLoanCommand
{
    public function __construct(
        public UuidInterface $clientId,
        public UuidInterface $productId,
    ) {
    }
}
