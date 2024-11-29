<?php

namespace App\Infrastructure\DB\Repository;

use App\Domain\Entity\Client as DomainClient;
use App\Domain\Exception\DomainException;
use App\Domain\Exception\InvalidEmailException;
use App\Domain\Repository\ClientRepositoryInterface;
use App\Entity\Client;
use App\Infrastructure\DB\Factory\ClientFactory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
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

    /**
     * @return DomainClient[]
     * @throws DomainException
     * @throws InvalidEmailException
     */
    public function getAll(): array
    {
        $clients = $this->findAll();

        return array_map(
            fn (Client $client) => $this->clientFactory->createFromDoctrineEntity($client),
            $clients,
        );
    }

    /**
     * @throws DomainException
     * @throws InvalidEmailException
     */
    public function create(DomainClient $client): DomainClient
    {
        $doctrineClient = new Client(
            id: $client->id,
            firstName: $client->fullName->firstName,
            lastName: $client->fullName->lastName,
            email: $client->email,
            dateOfBirth: $client->dateOfBirth->value,
            ssn: $client->ssn,
            address: $client->address->toArray(),
            creditRating: $client->creditRating->value,
            phoneNumber: $client->phoneNumber,
            monthlyIncome: $client->income->monthly,
            messagingChannel: $client->preferences->messagingChannel,
        );

        try {
            $this->getEntityManager()->persist($doctrineClient);
            $this->getEntityManager()->flush();
        } catch (UniqueConstraintViolationException $e) {
            throw new DomainException('Client with this email or phone number already exists.');
        }

        return $this->clientFactory->createFromDoctrineEntity($doctrineClient);
    }

    /**
     * @throws DomainException
     */
    public function update(DomainClient $client): DomainClient
    {
        /**
         * @var Client $record
         */
        $record = $this->find($client->id);

        if ($record === null) {
            throw new DomainException('Client not found');
        }

        $record->setFirstName($client->fullName->firstName);
        $record->setLastName($client->fullName->lastName);
        $record->setEmail($client->email);
        $record->setDateOfBirth($client->dateOfBirth->value);
        $record->setSsn($client->ssn);
        $record->setAddress($client->address->toArray());
        $record->setCreditRating($client->creditRating->value);
        $record->setPhoneNumber($client->phoneNumber);
        $record->setMonthlyIncome($client->income->monthly);
        $record->setMessagingChannel($client->preferences->messagingChannel);

        try {
            $this->getEntityManager()->persist($record);
            $this->getEntityManager()->flush();
        } catch (UniqueConstraintViolationException $e) {
            throw new DomainException('Client with this email or phone number already exists.');
        } catch (Exception $e) {
            throw new DomainException('An error occurred while updating the client.');
        }

        return $this->clientFactory->createFromDoctrineEntity($record);
    }
}
