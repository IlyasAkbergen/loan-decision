<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Domain\Enum\ProductCode;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product(
            id: Uuid::uuid4(),
            name: 'Product 1',
            code: ProductCode::PERSONAL_LOAN->value,
            termMonths: 12,
            interestRate: 5.5,
            sum: 1000,
        );
        $manager->persist($product);
        $manager->flush();
    }
}
