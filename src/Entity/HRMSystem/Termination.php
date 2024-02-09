<?php

namespace App\Entity\HRMSystem;

use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\HRMSystem\TerminationRepository;

#[ORM\Entity(repositoryClass: TerminationRepository::class)]
class Termination
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $employee = null;

    #[ORM\Column(length: 255)]
    private ?string $terminationType = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $noticeDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $terminationDate = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "trip")]
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

    public function getTerminationType(): ?string
    {
        return $this->terminationType;
    }

    public function setTerminationType(string $terminationType): static
    {
        $this->terminationType = $terminationType;

        return $this;
    }

    public function getNoticeDate(): ?\DateTimeInterface
    {
        return $this->noticeDate;
    }

    public function setNoticeDate(\DateTimeInterface $noticeDate): static
    {
        $this->noticeDate = $noticeDate;

        return $this;
    }

    public function getTerminationDate(): ?\DateTimeInterface
    {
        return $this->terminationDate;
    }

    public function setTerminationDate(\DateTimeInterface $terminationDate): static
    {
        $this->terminationDate = $terminationDate;

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
