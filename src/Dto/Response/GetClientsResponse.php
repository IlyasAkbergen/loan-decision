<?php

declare(strict_types=1);

namespace App\Dto\Response;

use App\Domain\Entity\Client;

class GetClientsResponse
{
    /**
     * @var Client[] $clients
     */
    public function __construct(
        public array $clients = [],
        public ?string $error = null,
    ) {
    }
}
