<?php

namespace App\Entity\WorkFlowSystem\Sales;

use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\WorkFlowSystem\Sales\EnquiryCreationRepository;

#[ORM\Entity(repositoryClass: EnquiryCreationRepository::class)]
class EnquiryCreation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $productCode = null;

    #[ORM\Column(type: 'integer')]
private ?int $productQty = null;

    #[ORM\Column(length: 255)]
    private ?string $requiredDate = null;

    #[ORM\Column(type: 'text')]
    private ?string $productCode2 = null;

    #[ORM\Column(type: 'text')]
    private ?string $orderBy = null;

    #[ORM\Column(type: 'text')]
    private ?string $orderUnder = null;

    #[ORM\Column(type: 'text')]
    private ?string $orderFor = null;

    #[ORM\Column(type: 'float')]
    private ?float $requiredPrice = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "enquiry create")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductCode(): ?string
    {
        return $this->productCode;
    }

    public function setProductCode(string $productCode): static
    {
        $this->productCode = $productCode;

        return $this;
    }

    public function getProductQty(): ?int
    {
        return $this->productQty;
    }

    public function setProductQty(int $productQty): static
    {
        $this->productQty = $productQty;

        return $this;
    }

    public function getRequiredDate(): ?string
    {
        return $this->requiredDate;
    }

    public function setRequiredDate(string $requiredDate): static
    {
        $this->requiredDate = $requiredDate;

        return $this;
    }

    public function getProductCode2(): ?string
    {
        return $this->productCode2;
    }

    public function setProductCode2(string $productCode2): static
    {
        $this->productCode2 = $productCode2;

        return $this;
    }

    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }

    public function setOrderBy(string $orderBy): static
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    public function getOrderUnder(): ?string
    {
        return $this->orderUnder;
    }

    public function setOrderUnder(string $orderUnder): static
    {
        $this->orderUnder = $orderUnder;

        return $this;
    }

    public function getOrderFor(): ?string
    {
        return $this->orderFor;
    }

    public function setOrderFor(string $orderFor): static
    {
        $this->orderFor = $orderFor;

        return $this;
    }

    public function getRequiredPrice(): ?float
    {
        return $this->requiredPrice;
    }

    public function setRequiredPrice(float $requiredPrice): static
    {
        $this->requiredPrice = $requiredPrice;

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
}