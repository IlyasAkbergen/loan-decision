<?php

declare(strict_types=1);

namespace App\Infrastructure\DB\Factory;

use App\Domain\Entity\Product as DomainProduct;
use App\Domain\Enum\ProductCode;
use App\Domain\ValueObject\InterestRate;
use App\Domain\ValueObject\Term;
use App\Entity\Product as DoctrineProduct;

class ProductFactory
{
    public function createFromDoctrineEntity(DoctrineProduct $product): DomainProduct
    {
        return new DomainProduct(
            $product->getId(),
            $product->getName(),
            ProductCode::from($product->getCode()),
            Term::fromMonths($product->getTermMonths()),
            new InterestRate($product->getInterestRate()),
            $product->getSum(),
        );
    }

    public function createDoctrineEntity(DomainProduct $product): DoctrineProduct
    {
        return new DoctrineProduct(
            id: $product->id,
            name: $product->name,
            code: $product->code->value,
            termMonths: $product->term->months,
            interestRate: $product->interestRate->value,
            sum: $product->sum,
        );
    }
}
