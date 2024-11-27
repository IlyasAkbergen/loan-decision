<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Client;
use Ramsey\Uuid\UuidInterface;

interface ClientRepositoryInterface
{
    public function findById(UuidInterface $id): ?Client;
}
