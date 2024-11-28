<?php

declare(strict_types=1);

namespace App\Handler;

use App\Domain\Exception\DomainException;
use App\Domain\Repository\ClientRepositoryInterface;
use App\Dto\Command\CreateClientCommand;
use App\Dto\Response\CreateClientResponse;
use App\Factory\ClientFactory;

class CreateClientHandler
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
        private ClientFactory $clientFactory,
    ) {
    }

    public function __invoke(CreateClientCommand $dto): CreateClientResponse
    {
        $client = $this->clientFactory->createFromCreateCommand($dto);
        try {
            $this->clientRepository->create($client);
        } catch (DomainException $e) {
            return new CreateClientResponse(client: $client, error: $e->getMessage());
        } catch (\Exception $e) {
            return new CreateClientResponse(client: $client, error: 'An error occurred while creating the client.');
        }


        return new CreateClientResponse(client: $client);
    }
}
