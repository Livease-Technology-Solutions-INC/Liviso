<?php

namespace App\Entity\HRMSystem\HRM_System_Setup;

use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\HRMSystem\HRM_System_Setup\LeaveRepository;

#[ORM\Entity(repositoryClass: LeaveRepository::class)]
class Leave
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $leaveType = null;

    #[ORM\Column(length: 255)]
    private ?string $daysPerYear = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "leaveType")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLeaveType(): ?string
    {
        return $this->leaveType;
    }

    public function setLeaveType(string $leaveType): static
    {
        $this->leaveType = $leaveType;

        return $this;
    }

    public function getDaysPerYear(): ?string
    {
        return $this->daysPerYear;
    }

    public function setDaysPerYear(string $daysPerYear): static
    {
        $this->daysPerYear = $daysPerYear;

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
