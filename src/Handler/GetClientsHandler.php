<?php

declare(strict_types=1);

namespace App\Handler;

use App\Domain\Repository\ClientRepositoryInterface;
use App\Infrastructure\Http\Dto\Response\GetClientsResponse;

readonly class GetClientsHandler
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
    ) {
    }

    public function __invoke(): GetClientsResponse
    {
        return new GetClientsResponse(clients: $this->clientRepository->getAll());
    }
}
