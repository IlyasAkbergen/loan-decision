<?php

declare(strict_types=1);

namespace App\Handler;

use App\Dto\Response\GetClientsResponse;
use App\Repository\ClientRepository;

readonly class GetClientsHandler
{
    public function __construct(
        private ClientRepository $clientRepository,
    ) {
    }

    public function __invoke(): GetClientsResponse
    {
        return new GetClientsResponse(clients: $this->clientRepository->findAll());
    }
}
