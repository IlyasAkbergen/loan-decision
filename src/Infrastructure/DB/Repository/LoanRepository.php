<?php

declare(strict_types=1);

namespace App\Infrastructure\DB\Repository;

use App\Domain\Entity\Loan as DomainLoan;
use App\Domain\Exception\DomainException;
use App\Domain\Exception\InvalidEmailException;
use App\Domain\Repository\LoanRepositoryInterface;
use App\Entity\Client;
use App\Entity\Loan;
use App\Entity\Product;
use App\Infrastructure\DB\Factory\LoanFactory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Loan>
 */
class LoanRepository extends ServiceEntityRepository implements LoanRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private LoanFactory $loanFactory,
    ) {
        parent::__construct($registry, Loan::class);
    }

    /**
     * @throws DomainException
     * @throws InvalidEmailException
     * @throws ORMException
     */
    public function save(DomainLoan $loan): DomainLoan
    {
        $loan = $this->loanFactory->createDoctrineEntity($loan);

        $loan->setClient($this->getEntityManager()->getReference(Client::class, $loan->getClient()->getId()));
        $loan->setProduct(
            $this->getEntityManager()->getReference(Product::class, $loan->getProduct()->getId())
        );
        $this->getEntityManager()->persist($loan);
        $this->getEntityManager()->flush();

        return $this->loanFactory->createFromDoctrineEntity($loan);
    }
}
