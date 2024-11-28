<?php

declare(strict_types=1);

namespace App\Dto\Response;

use App\Domain\Entity\Client;

readonly class CreateClientResponse
{
    public function __construct(
        public Client $client,
        public ?string $error = null,
    ) {
    }
}
