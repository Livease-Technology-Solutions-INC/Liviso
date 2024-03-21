<?php

namespace App\Entity\AccountingSystem\Income;

use App\Entity\User;
use App\Entity\AccountingSystem\Customer;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AccountingSystem\RevenueRepository;

#[ORM\Entity(repositoryClass: RevenueRepository::class)]
class Revenue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $amount = null;

    #[ORM\Column(length: 255)]
    private ?string $account = null;

    #[ORM\Column(length: 255)]
    private ?string $customers = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $paymentReceipt = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "revenue")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $user = null;
    


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getAccount(): ?string
    {
        return $this->account;
    }

    public function setAccount(string $account): static
    {
        $this->account = $account;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPaymentReceipt(): ?string
    {
        return $this->paymentReceipt;
    }

    public function setPaymentReceipt(string $paymentReceipt): static
    {
        $this->paymentReceipt = $paymentReceipt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCustomers(): ?string
    {
        return $this->customers;
    }

    public function setCustomers(string $customers): static
    {
        $this->customers = $customers;

        return $this;
    }
}