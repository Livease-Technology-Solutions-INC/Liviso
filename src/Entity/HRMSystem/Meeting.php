<?php

namespace App\Entity\HRMSystem;

use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\HRMSystem\MeetingRepository;

#[ORM\Entity(repositoryClass: MeetingRepository::class)]
class Meeting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $branch = null;

    #[ORM\Column(length: 255)]
    private ?string $department = null;

    #[ORM\Column(length: 255)]
    private ?string $employee = null;

    #[ORM\Column(length: 255)]
    private ?string $meetingTitle = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $meetingDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $meetingTime = null;

    #[ORM\Column(type: 'text')]
    private ?string $meetingNote = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "meeting")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBranch(): ?string
    {
        return $this->branch;
    }

    public function setBranch(string $branch): static
    {
        $this->branch = $branch;

        return $this;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(string $department): static
    {
        $this->department = $department;

        return $this;
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

    public function getMeetingTitle(): ?string
    {
        return $this->meetingTitle;
    }

    public function setMeetingTitle(string $meetingTitle): static
    {
        $this->meetingTitle = $meetingTitle;

        return $this;
    }

    public function getMeetingDate(): ?\DateTimeInterface
    {
        return $this->meetingDate;
    }

    public function setMeetingDate(\DateTimeInterface $meetingDate): static
    {
        $this->meetingDate = $meetingDate;

        return $this;
    }

    public function getMeetingTime(): ?\DateTimeInterface
    {
        return $this->meetingTime;
    }

    public function setMeetingTime(\DateTimeInterface $meetingTime): static
    {
        $this->meetingTime = $meetingTime;

        return $this;
    }

    public function getMeetingNote(): ?string
    {
        return $this->meetingNote;
    }

    public function setMeetingNote(string $meetingNote): static
    {
        $this->meetingNote = $meetingNote;

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
