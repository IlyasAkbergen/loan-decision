<?php

namespace App\Entity;

use App\Repository\LoanRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: LoanRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Loan
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private UuidInterface $id;

    #[ORM\ManyToOne(inversedBy: 'loans')]
    #[ORM\JoinColumn(nullable: false)]
    private Client $client;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Product $product;

    #[ORM\Column(name: 'term_months')]
    private int $termMonths;

    #[ORM\Column(name: 'interest_rate')]
    private float $interestRate;

    #[ORM\Column]
    private float $sum;

    #[ORM\Column(name: 'created_at')]
    private DateTimeImmutable $createdAt;

    public function __construct(
        UuidInterface $id,
        Client $client,
        Product $product,
        int $termMonths,
        float $interestRate,
        float $sum,
    ) {
        $this->id = $id;
        $this->client = $client;
        $this->product = $product;
        $this->termMonths = $termMonths;
        $this->interestRate = $interestRate;
        $this->sum = $sum;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getTermMonths(): int
    {
        return $this->termMonths;
    }

    public function getInterestRate(): float
    {
        return $this->interestRate;
    }

    public function getSum(): float
    {
        return $this->sum;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }
    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new DateTimeImmutable();
    }
}
