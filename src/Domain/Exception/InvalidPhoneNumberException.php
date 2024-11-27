<?php

declare(strict_types=1);

namespace App\Domain\Exception;

class InvalidPhoneNumberException extends DomainException
{
    public function __construct(string $phoneNumber)
    {
        parent::__construct(sprintf('Invalid phone number: %s', $phoneNumber));
    }
}
