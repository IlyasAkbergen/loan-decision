<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Dto\Response;

use App\Domain\Entity\Client;

readonly class GetClientResponse
{
    public function __construct(
        public ?Client $client = null,
        public ?string $error = null,
    ) {
    }
}
