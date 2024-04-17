<?php

namespace App\Entity\HRMSystem\PayrollSetup;

use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\HRMSystem\SetSalaryRepository;

#[ORM\Entity(repositoryClass: SetSalaryRepository::class)]
class Salary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $payrollType = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $salary = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $netSalary = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "set salary")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPayrollType(): ?string
    {
        return $this->payrollType;
    }

    public function setPayrollType(string $payrollType): static
    {
        $this->payrollType = $payrollType;

        return $this;
    }

    public function getSalary(): ?string
    {
        return $this->salary;
    }

    public function setSalary(string $salary): static
    {
        $this->salary = $salary;

        return $this;
    }

    public function getNetSalary(): ?string
    {
        return $this->netSalary;
    }

    public function setNetSalary(string $netSalary): static
    {
        $this->netSalary = $netSalary;

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