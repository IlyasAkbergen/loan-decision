<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Domain\Entity\Product as DomainProduct;
use App\Domain\Enum\ProductCode;
use App\Domain\ValueObject\InterestRate;
use App\Domain\ValueObject\Term;
use App\Entity\Product as DoctrineProduct;
use App\Factory\ProductFactory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ProductFactoryTest extends TestCase
{
    public static function provideCreateFromDoctrineEntity(): array
    {
        return [
            'test' => [
                'product' => new DoctrineProduct(
                    Uuid::fromString('f1f1f1f1-f1f1-f1f1-f1f1-f1f1f1f1f1f1'),
                    'Test Product',
                    ProductCode::PERSONAL_LOAN->value,
                    12,
                    10,
                    1000,
                ),
                'expected' => new DomainProduct(
                    Uuid::fromString('f1f1f1f1-f1f1-f1f1-f1f1-f1f1f1f1f1f1'),
                    'Test Product',
                    ProductCode::PERSONAL_LOAN,
                    Term::fromMonths(12),
                    new InterestRate(10),
                    1000,
                ),
            ],
        ];
    }

    #[dataProvider('provideCreateFromDoctrineEntity')]
    public function testCreateFromDoctrineEntity(
        DoctrineProduct $product,
        DomainProduct $expected,
    ): void {
        $actual = $this->getProductFactory()->createFromDoctrineEntity($product);

        self::assertEquals($expected, $actual);
    }

    private function getProductFactory(): ProductFactory
    {
        return new ProductFactory();
    }
}
