<?php

namespace App\Infrastructure\DB\Repository;

use App\Domain\Entity\Product as DomainProduct;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Entity\Product;
use App\Infrastructure\DB\Factory\ProductFactory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private ProductFactory $productFactory,
    ) {
        parent::__construct($registry, Product::class);
    }

    public function findById(UuidInterface $id): ?DomainProduct
    {
        $product = $this->find($id);

        if ($product === null) {
            return null;
        }

        return $this->productFactory->createFromDoctrineEntity($product);
    }

    /**
     * @return DomainProduct[]
     */
    public function getAll(): array
    {
        $products = $this->findAll();

        return array_map(
            fn (Product $product) => $this->productFactory->createFromDoctrineEntity($product),
            $products,
        );
    }
}
