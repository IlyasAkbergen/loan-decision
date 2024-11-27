<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\InvalidPhoneNumberException;

readonly class PhoneNumber
{
    /**
     * @throws InvalidPhoneNumberException
     */
    public function __construct(
        public string $value,
    ) {
        if (!preg_match('/^\+?[1-9]\d{1,14}$/', $this->value)) {
            // the rule can be easily changed to fit the project requirements
            throw new InvalidPhoneNumberException($this->value);
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
