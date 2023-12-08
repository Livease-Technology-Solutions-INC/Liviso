<?php

namespace App\Entity\HRMSystem;

use App\Repository\HRMSystem\ResignationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResignationRepository::class)]
class Resignation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $employee= null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $noticeDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $resignationDate = null;

    #[ORM\Column(length: 255)]
    private ?string $Description= null;

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

    public function getNoticeDate(): ?\DateTimeInterface
    {
        return $this->noticeDate;
    }

    public function setNoticeDate(\DateTimeInterface $noticeDate): static
    {
        $this->noticeDate = $noticeDate;

        return $this;
    }

    public function getResignationDate(): ?\DateTimeInterface
    {
        return $this->resignationDate;
    }

    public function setResignationDate(\DateTimeInterface $resignationDate): static
    {
        $this->resignationDate = $resignationDate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

}
