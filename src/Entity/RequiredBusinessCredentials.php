<?php

namespace App\Entity;

use App\Repository\RequiredBusinessCredentialsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RequiredBusinessCredentialsRepository::class)]
class RequiredBusinessCredentials
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $companyLicense = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $taxCertificate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $personalId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phoneNumber = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyLicense(): ?string
    {
        return $this->companyLicense;
    }

    public function setCompanyLicense(?string $companyLicense): static
    {
        $this->companyLicense = $companyLicense;

        return $this;
    }

    public function getTaxCertificate(): ?string
    {
        return $this->taxCertificate;
    }

    public function setTaxCertificate(?string $taxCertificate): static
    {
        $this->taxCertificate = $taxCertificate;

        return $this;
    }

    public function getPersonalId(): ?string
    {
        return $this->personalId;
    }

    public function setPersonalId(?string $personalId): static
    {
        $this->personalId = $personalId;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }
}
