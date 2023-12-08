<?php

namespace App\Entity;

use App\Repository\EmployeeAssetSetupRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeAssetSetupRepository::class)]
class EmployeeAssetSetup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Employee = null;

    #[ORM\Column(length: 255)]
    private ?string $EmployeeName = null;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $purchaseDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $supportedDate = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployee(): ?string
    {
        return $this->Employee;
    }

    public function setEmployee(string $Employee): static
    {
        $this->Employee = $Employee;

        return $this;
    }

    public function getEmployeeName(): ?string
    {
        return $this->EmployeeName;
    }

    public function setEmployeeName(string $EmployeeName): static
    {
        $this->EmployeeName = $EmployeeName;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPurchaseDate(): ?\DateTimeInterface
    {
        return $this->purchaseDate;
    }

    public function setPurchaseDate(\DateTimeInterface $purchaseDate): static
    {
        $this->purchaseDate = $purchaseDate;

        return $this;
    }

    public function getSupportedDate(): ?\DateTimeInterface
    {
        return $this->supportedDate;
    }

    public function setSupportedDate(\DateTimeInterface $supportedDate): static
    {
        $this->supportedDate = $supportedDate;

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
}
