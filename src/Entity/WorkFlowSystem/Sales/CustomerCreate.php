<?php

namespace App\Entity\WorkFlowSystem\Sales;

use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\WorkFlowSystem\Sales\CustomerCreateRepository;

#[ORM\Entity(repositoryClass: CustomerCreateRepository::class)]
class CustomerCreate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $companyName = null;

    #[ORM\Column(length: 255)]
    private ?string $companyAddress = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(type: 'text')]
    private ?string $authorizedPerson = null;

    #[ORM\Column(type: 'text')]
    private ?string $phoneNumber = null;

    #[ORM\Column(type: 'text')]
    private ?string $contactEmail = null;

    #[ORM\Column(type: 'text')]
    private ?string $branch1 = null;

    #[ORM\Column(type: 'text')]
    private ?string $branch2 = null;

    #[ORM\Column(type: 'text')]
    private ?string $preferredDeliveryLocation = null;

    #[ORM\Column(type: 'text')]
    private ?string $contactNumberOfReceiver = null;

    #[ORM\Column(type: 'text')]
    private ?string $TradeLicense = null;

    #[ORM\Column(type: 'text')]
    private ?string $partnerPassportId = null;

    #[ORM\Column(type: 'text')]
    private ?string $creditTerms = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "customer create")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): static
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getCompanyAddress(): ?string
    {
        return $this->companyAddress;
    }

    public function setCompanyAddress(string $companyAddress): static
    {
        $this->companyAddress = $companyAddress;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getAuthorizedPerson(): ?string
    {
        return $this->authorizedPerson;
    }

    public function setAuthorizedPerson(string $authorizedPerson): static
    {
        $this->authorizedPerson = $authorizedPerson;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->contactEmail;
    }

    public function setContactEmail(string $contactEmail): static
    {
        $this->contactEmail = $contactEmail;

        return $this;
    }

    public function getBranch1(): ?string
    {
        return $this->branch1;
    }

    public function setBranch1(string $branch1): static
    {
        $this->branch1 = $branch1;

        return $this;
    }

    public function getBranch2(): ?string
    {
        return $this->branch2;
    }

    public function setBranch2(string $branch2): static
    {
        $this->branch2 = $branch2;

        return $this;
    }

    public function getPreferredDeliveryLocation(): ?string
    {
        return $this->preferredDeliveryLocation;
    }

    public function setPreferredDeliveryLocation(string $preferredDeliveryLocation): static
    {
        $this->preferredDeliveryLocation = $preferredDeliveryLocation;

        return $this;
    }

    public function getContactNumberOfReceiver(): ?string
    {
        return $this->contactNumberOfReceiver;
    }

    public function setContactNumberOfReceiver(string $contactNumberOfReceiver): static
    {
        $this->contactNumberOfReceiver = $contactNumberOfReceiver;

        return $this;
    }

    public function getTradeLicense(): ?string
    {
        return $this->TradeLicense;
    }

    public function setTradeLicense(string $TradeLicense): static
    {
        $this->TradeLicense = $TradeLicense;

        return $this;
    }

    public function getPartnerPassportId(): ?string
    {
        return $this->partnerPassportId;
    }

    public function setPartnerPassportId(string $partnerPassportId): static
    {
        $this->partnerPassportId = $partnerPassportId;

        return $this;
    }

    public function getCreditTerms(): ?string
    {
        return $this->creditTerms;
    }

    public function setCreditTerms(string $creditTerms): static
    {
        $this->creditTerms = $creditTerms;

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