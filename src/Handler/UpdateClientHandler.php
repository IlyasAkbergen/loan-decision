<?php

declare(strict_types=1);

namespace App\Handler;

use App\Domain\Exception\DomainException;
use App\Domain\Repository\ClientRepositoryInterface;
use App\Dto\Command\UpdateClientCommand;
use App\Dto\Response\UpdateClientResponse;
use App\Factory\ClientFactory;
use Ramsey\Uuid\UuidInterface;

class UpdateClientHandler
{
    public function __construct(
        private ClientFactory $clientFactory,
        private ClientRepositoryInterface $clientRepository,
    ) {
    }

    public function __invoke(UuidInterface $id, UpdateClientCommand $command): UpdateClientResponse
    {
        try {
            $client = $this->clientFactory->createFromUpdateCommand($id, $command);
            $client = $this->clientRepository->update($client);
        } catch (DomainException $e) {
            return new UpdateClientResponse(
                client: $this->clientFactory->createFromUpdateCommand($id, $command),
                error: $e->getMessage(),
            );
        } catch (\Exception $e) {
            return new UpdateClientResponse(
                client: $client ?? null,
                error: 'An error occurred while updating the client.',
            );
        }

        return new UpdateClientResponse(client: $client);
    }
}
