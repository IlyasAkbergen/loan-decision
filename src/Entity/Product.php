<?php

declare(strict_types=1);

namespace App\Entity;

use App\Infrastructure\DB\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private UuidInterface $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255)]
    private string $code;

    #[ORM\Column]
    private int $termMonths;

    #[ORM\Column]
    private float $interestRate;

    #[ORM\Column]
    private float $sum;

    public function __construct(
        UuidInterface $id,
        string $name,
        string $code,
        int $termMonths,
        float $interestRate,
        float $sum,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
        $this->termMonths = $termMonths;
        $this->interestRate = $interestRate;
        $this->sum = $sum;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
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

    public function getCode(): string
    {
        return $this->code;
    }
}
