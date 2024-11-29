<?php

declare(strict_types=1);

namespace App\Entity;

use App\Domain\Enum\MessagingChannel;
use App\Infrastructure\DB\Repository\ClientRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private UuidInterface $id;

    #[ORM\Column(name: 'first_name', type: 'string', length: 255)]
    private string $firstName;

    #[ORM\Column(name: 'last_name', type: 'string', length: 255)]
    private string $lastName;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $email;

    #[ORM\Column(name: 'date_of_birth', type: Types::DATE_IMMUTABLE)]
    private DateTimeImmutable $dateOfBirth;

    #[ORM\Column(length: 255)]
    private string $ssn;

    #[ORM\Column(type: 'json')]
    private array $address;

    #[ORM\Column(name: 'credit_rating', type: 'integer')]
    private int $creditRating;

    #[ORM\Column(name: 'phone_number', type: 'string', length: 255, unique: true)]
    private string $phoneNumber;

    #[ORM\Column(name: 'monthly_income', type: 'float')]
    private float $monthlyIncome;

    #[ORM\Column(name: 'messaging_channel', type: 'string', enumType: MessagingChannel::class)]
    private MessagingChannel $messagingChannel;

    public function __construct(
        UuidInterface $id,
        string $firstName,
        string $lastName,
        string $email,
        DateTimeImmutable $dateOfBirth,
        string $ssn,
        array $address,
        int $creditRating,
        string $phoneNumber,
        float $monthlyIncome,
        MessagingChannel $messagingChannel,
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->dateOfBirth = $dateOfBirth;
        $this->ssn = $ssn;
        $this->address = $address;
        $this->creditRating = $creditRating;
        $this->phoneNumber = $phoneNumber;
        $this->monthlyIncome = $monthlyIncome;
        $this->messagingChannel = $messagingChannel;
        $this->loans = new ArrayCollection();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getDateOfBirth(): DateTimeImmutable
    {
        return $this->dateOfBirth;
    }

    public function getSsn(): string
    {
        return $this->ssn;
    }

    public function getAddress(): array
    {
        return $this->address;
    }

    public function getCreditRating(): int
    {
        return $this->creditRating;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getMonthlyIncome(): float
    {
        return $this->monthlyIncome;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setDateOfBirth(DateTimeImmutable $dateOfBirth): void
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    public function setSsn(string $ssn): void
    {
        $this->ssn = $ssn;
    }

    public function setAddress(array $address): void
    {
        $this->address = $address;
    }

    public function setCreditRating(int $creditRating): void
    {
        $this->creditRating = $creditRating;
    }

    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function setMonthlyIncome(float $monthlyIncome): void
    {
        $this->monthlyIncome = $monthlyIncome;
    }

    public function getMessagingChannel(): MessagingChannel
    {
        return $this->messagingChannel;
    }

    public function setMessagingChannel(MessagingChannel $messagingChannel): void
    {
        $this->messagingChannel = $messagingChannel;
    }

    /**
     * @return Collection<int, Loan>
     */
    public function getLoans(): Collection
    {
        return $this->loans;
    }

    public function addLoan(Loan $loan): static
    {
        if (!$this->loans->contains($loan)) {
            $this->loans->add($loan);
            $loan->setClient($this);
        }

        return $this;
    }

    public function removeLoan(Loan $loan): static
    {
        if ($this->loans->removeElement($loan)) {
            // set the owning side to null (unless already changed)
            if ($loan->getClient() === $this) {
                $loan->setClient(null);
            }
        }

        return $this;
    }
}
