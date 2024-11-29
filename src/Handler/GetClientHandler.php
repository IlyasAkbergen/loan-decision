<?php

declare(strict_types=1);

namespace App\Handler;

use App\Domain\Repository\ClientRepositoryInterface;
use App\Infrastructure\Http\Dto\Query\GetClientQuery;
use App\Infrastructure\Http\Dto\Response\GetClientResponse;

class GetClientHandler
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
    ) {
    }

    public function __invoke(GetClientQuery $query): GetClientResponse
    {
        $client = $this->clientRepository->findById($query->id);

        return new GetClientResponse(
            client: $client,
            error: $client === null ? 'Client not found' : null,
        );
    }
}
