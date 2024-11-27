<?php

declare(strict_types=1);

namespace App\Domain\Exception;

class InvalidEmailException extends DomainException
{
    public function __construct(string $email)
    {
        parent::__construct(sprintf('Invalid email: %s', $email));
    }
}
