<?php

namespace App\Entity\HRMSystem;

use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\HRMSystem\WarningRepository;

#[ORM\Entity(repositoryClass: WarningRepository::class)]
class Warning
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $warningBy = null;

    #[ORM\Column(length: 255)]
    private ?string $warningTo = null;

    #[ORM\Column(length: 255)]
    private ?string $subject = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $warningDate = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "zoomMeetings")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWarningBy(): ?string
    {
        return $this->warningBy;
    }

    public function setWarningBy(string $warningBy): static
    {
        $this->warningBy = $warningBy;

        return $this;
    }

    public function getWarningTo(): ?string
    {
        return $this->warningTo;
    }

    public function setWarningTo(string $warningTo): static
    {
        $this->warningTo = $warningTo;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getWarningDate(): ?\DateTimeInterface
    {
        return $this->warningDate;
    }

    public function setWarningDate(\DateTimeInterface $warningDate): static
    {
        $this->warningDate = $warningDate;

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
