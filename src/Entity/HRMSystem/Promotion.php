<?php

namespace App\Entity\HRMSystem;

use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\HRMSystem\PromotionRepository;

#[ORM\Entity(repositoryClass: PromotionRepository::class)]
class Promotion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $employee = null;

    #[ORM\Column(length: 255)]
    private ?string $designation = null;

    #[ORM\Column(length: 255)]
    private ?string $promotionTitle= null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $promotionDate = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "promotion")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployee(): ?string
    {
        return $this->employee;
    }

    public function setEmployee(string $employee): static
    {
        $this->employee = $employee;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    public function getPromotionTitle(): ?string
    {
        return $this->promotionTitle;
    }

    public function setPromotionTitle(string $promotionTitle): static
    {
        $this->promotionTitle = $promotionTitle;

        return $this;
    }

    public function getPromotionDate(): ?\DateTimeInterface
    {
        return $this->promotionDate;
    }

    public function setPromotionDate(\DateTimeInterface $promotionDate): static
    {
        $this->promotionDate = $promotionDate;

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
