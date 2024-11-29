<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Address;
use App\Domain\ValueObject\CreditRating;
use App\Domain\ValueObject\DateOfBirth;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\FullName;
use App\Domain\ValueObject\Income;
use App\Domain\ValueObject\PhoneNumber;
use App\Domain\ValueObject\Preferences;
use App\Domain\ValueObject\SSN;
use Ramsey\Uuid\UuidInterface;

class Client
{
    function __construct(
        public readonly UuidInterface $id,
        public FullName $fullName,
        public Email $email,
        public DateOfBirth $dateOfBirth,
        public SSN $ssn,
        public Address $address,
        public CreditRating $creditRating,
        public PhoneNumber $phoneNumber,
        public Income $income,
        public Preferences $preferences,
    ) {
    }
}
