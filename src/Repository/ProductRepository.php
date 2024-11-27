<?php

namespace App\Repository;

use App\Domain\Entity\Product as DomainProduct;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Entity\Product;
use App\Factory\ProductFactory;
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

    //    /**
    //     * @return Product[] Returns an array of Product objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findById(UuidInterface $id): ?DomainProduct
    {
        $product = $this->find($id);

        if ($product === null) {
            return null;
        }

        return $this->productFactory->createFromDoctrineEntity($product);
    }
}
