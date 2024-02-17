<?php

namespace App\Entity\HRMSystem\HRM_System_Setup;

use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\HRMSystem\HRM_System_Setup\TerminationHRMRepository;

#[ORM\Entity(repositoryClass: TerminationHRMRepository::class)]
class TerminationHRM
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $termination = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "termination")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTermination(): ?string
    {
        return $this->termination;
    }

    public function setTermination(string $termination): static
    {
        $this->termination = $termination;

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
