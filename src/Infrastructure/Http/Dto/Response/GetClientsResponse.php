<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Dto\Response;

use App\Domain\Entity\Client;

readonly class GetClientsResponse
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
