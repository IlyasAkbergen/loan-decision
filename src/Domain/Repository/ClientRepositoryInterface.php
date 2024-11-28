<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Client;
use App\Domain\Exception\DomainException;
use Ramsey\Uuid\UuidInterface;

interface ClientRepositoryInterface
{
    public function findById(UuidInterface $id): ?Client;

    /**
     * @return Client[]
     */
    public function getAll(): array;

    /**
     * @throws DomainException
     */
    public function create(Client $client): Client;

    public function update(Client $client): Client;
}
