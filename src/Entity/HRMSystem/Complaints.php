<?php

namespace App\Entity\HRMSystem;

use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\HRMSystem\ComplaintsRepository;

#[ORM\Entity(repositoryClass: ComplaintsRepository::class)]
class Complaints
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $complaintFrom = null;

    #[ORM\Column(length: 255)]
    private ?string $complaintAgainst = null;

    #[ORM\Column(length: 255)]
    private ?string $complaintTitle = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $complaintDate = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "zoomMeetings")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $user = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComplaintFrom(): ?string
    {
        return $this->complaintFrom;
    }

    public function setComplaintFrom(string $complaintFrom): static
    {
        $this->complaintFrom = $complaintFrom;

        return $this;
    }

    public function getComplaintAgainst(): ?string
    {
        return $this->complaintAgainst;
    }

    public function setComplaintAgainst(string $complaintAgainst): static
    {
        $this->complaintAgainst = $complaintAgainst;

        return $this;
    }

    public function getComplaintTitle(): ?string
    {
        return $this->complaintTitle;
    }

    public function setComplaintTitle(string $complaintTitle): static
    {
        $this->complaintTitle = $complaintTitle;

        return $this;
    }

    public function getComplaintDate(): ?\DateTimeInterface
    {
        return $this->complaintDate;
    }

    public function setComplaintDate(\DateTimeInterface $complaintDate): static
    {
        $this->complaintDate = $complaintDate;

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
