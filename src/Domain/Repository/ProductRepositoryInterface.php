<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Product;
use Ramsey\Uuid\UuidInterface;

interface ProductRepositoryInterface
{
    public function findById(UuidInterface $id): ?Product;

    /**
     * @return Product[]
     */
    public function getAll(): array;
}
