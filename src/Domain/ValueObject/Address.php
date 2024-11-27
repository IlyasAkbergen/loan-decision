<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use JsonSerializable;

readonly class Address implements JsonSerializable
{
    public function __construct(
        public string $street,
        public string $city,
        public string $state,
        public string $zip,
    ) {
    }

    public static function fromArray(Address|array $address): self
    {
        return new self(
            $address['street'],
            $address['city'],
            $address['state'],
            $address['zip'],
        );
    }

    public function __toString(): string
    {
        return sprintf('%s, %s, %s %s', $this->street, $this->city, $this->state, $this->zip);
    }

    public function toArray(): array
    {
        return [
            'street' => $this->street,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
