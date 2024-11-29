<?php

declare(strict_types=1);

namespace App\Factory;

use App\Domain\Entity\Client as DomainClient;
use App\Domain\Exception\DomainException;
use App\Domain\Exception\InvalidEmailException;
use App\Domain\ValueObject\Address;
use App\Domain\ValueObject\CreditRating;
use App\Domain\ValueObject\DateOfBirth;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\FullName;
use App\Domain\ValueObject\Income;
use App\Domain\ValueObject\PhoneNumber;
use App\Domain\ValueObject\Preferences;
use App\Domain\ValueObject\SSN;
use App\Dto\Command\CreateClientCommand;
use App\Dto\Command\UpdateClientCommand;
use App\Entity\Client as DoctrineClient;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ClientFactory
{
    /**
     * @throws InvalidEmailException
     * @throws DomainException
     */
    public function createFromDoctrineEntity(DoctrineClient $client): DomainClient {
        return new DomainClient(
            id: $client->getId(),
            fullName: new FullName($client->getFirstName(), $client->getLastName()),
            email: new Email($client->getEmail()),
            dateOfBirth: new DateOfBirth($client->getDateOfBirth()),
            ssn: new SSN($client->getSsn()),
            address: Address::fromArray($client->getAddress()),
            creditRating: new CreditRating($client->getCreditRating()),
            phoneNumber: new PhoneNumber($client->getPhoneNumber()),
            income: Income::fromMonthly($client->getMonthlyIncome()),
            preferences: new Preferences(
                messagingChannel: $client->getMessagingChannel(),
            ),
        );
    }

    public function createFromCreateCommand(CreateClientCommand $dto): DomainClient
    {
        return new DomainClient(
            id: Uuid::uuid4(),
            fullName: new FullName($dto->firstName, $dto->lastName),
            email: new Email($dto->email),
            dateOfBirth: new DateOfBirth($dto->dateOfBirth),
            ssn: new SSN($dto->ssn),
            address: new Address(
                street: $dto->street,
                city: $dto->city,
                state: $dto->state,
                zip: $dto->zip
            ),
            creditRating: new CreditRating($dto->creditRating),
            phoneNumber: new PhoneNumber($dto->phone),
            income: Income::fromMonthly($dto->income),
            preferences: new Preferences(
                messagingChannel: $dto->messagingChannel,
            ),
        );
    }

    public function createFromUpdateCommand(UuidInterface $id, UpdateClientCommand $command): DomainClient
    {
        return new DomainClient(
            id: $id,
            fullName: new FullName($command->firstName, $command->lastName),
            email: new Email($command->email),
            dateOfBirth: new DateOfBirth($command->dateOfBirth),
            ssn: new SSN($command->ssn),
            address: new Address(
                street: $command->street,
                city: $command->city,
                state: $command->state,
                zip: $command->zip
            ),
            creditRating: new CreditRating($command->creditRating),
            phoneNumber: new PhoneNumber($command->phone),
            income: Income::fromMonthly($command->income),
            preferences: new Preferences(
                messagingChannel: $command->messagingChannel,
            ),
        );
    }

    public function createDoctrineEntity(DomainClient $client): DoctrineClient
    {
        return new DoctrineClient(
            id: $client->id,
            firstName: $client->fullName->firstName,
            lastName: $client->fullName->lastName,
            email: $client->email->value,
            dateOfBirth: $client->dateOfBirth->value,
            ssn: $client->ssn->value,
            address: $client->address->toArray(),
            creditRating: $client->creditRating->value,
            phoneNumber: $client->phoneNumber->value,
            monthlyIncome: $client->income->monthly,
            messagingChannel: $client->preferences->messagingChannel,
        );
    }
}
