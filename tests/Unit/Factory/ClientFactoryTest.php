<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Domain\Entity\Client as DomainClient;
use App\Domain\Enum\MessagingChannel;
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
use App\Entity\Client;
use App\Factory\ClientFactory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ClientFactoryTest extends TestCase
{
    /**
     * @throws DomainException
     */
    public static function provideCreateFromDoctrineEntity(): array
    {
        return [
            'test' => [
                'client' => new Client(
                    Uuid::fromString('f1f1f1f1-f1f1-f1f1-f1f1-f1f1f1f1f1f1'),
                    'John',
                    'Doe',
                    'test@test.com',
                    new \DateTimeImmutable('1990-01-01'),
                    '123-45-6789',
                    (new Address(
                        '123 Main St',
                        'Anytown',
                        'AS',
                        '12345'
                    ))->toArray(),
                    700,
                    '+75555555555',
                    6000,
                    messagingChannel: MessagingChannel::EMAIL,
                ),
                'expected' => new DomainClient(
                    Uuid::fromString('f1f1f1f1-f1f1-f1f1-f1f1-f1f1f1f1f1f1'),
                    new FullName('John', 'Doe'),
                    new Email('test@test.com'),
                    new DateOfBirth(new \DateTimeImmutable('1990-01-01')),
                    new SSN('123-45-6789'),
                    new Address(
                        '123 Main St',
                        'Anytown',
                        'AS',
                        '12345'
                    ),
                    new CreditRating(700),
                    new PhoneNumber('+75555555555'),
                    Income::fromMonthly(6000),
                    preferences: new Preferences(
                        messagingChannel: MessagingChannel::EMAIL,
                    )
                ),
            ],
        ];
    }

    /**
     * @throws DomainException
     * @throws InvalidEmailException
     */
    #[dataProvider('provideCreateFromDoctrineEntity')]
    public function testCreateFromDoctrineEntity(
        Client $client,
        DomainClient $expected,
    ): void {
        $actual = $this->getFactory()->createFromDoctrineEntity($client);

        self::assertEquals($expected, $actual);
    }

    private function getFactory(): ClientFactory
    {
        return new ClientFactory();
    }
}
