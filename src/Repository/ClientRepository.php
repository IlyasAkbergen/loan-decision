<?php

namespace App\Repository;

use App\Domain\Entity\Client as DomainClient;
use App\Domain\Exception\DomainException;
use App\Domain\Exception\InvalidEmailException;
use App\Domain\Repository\ClientRepositoryInterface;
use App\Entity\Client;
use App\Factory\ClientFactory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

class ClientRepository extends ServiceEntityRepository implements ClientRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly ClientFactory $clientFactory,
    ) {
        parent::__construct($registry, Client::class);
    }

    /**
     * @throws DomainException
     * @throws InvalidEmailException
     */
    public function findById(UuidInterface $id): ?DomainClient
    {
        $client = $this->find($id);

        if ($client === null) {
            return null;
        }

        return $this->clientFactory->createFromDoctrineEntity($client);
    }
}
