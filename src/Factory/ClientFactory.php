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
use App\Domain\ValueObject\SSN;
use App\Entity\Client as DoctrineClient;

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
            income: Income::fromMonthly($client->getMonthlyIncome())
        );
    }
}
