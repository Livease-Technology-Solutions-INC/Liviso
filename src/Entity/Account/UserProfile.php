<?php

namespace App\Entity\Account;

use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Account\UserProfileRepository;

#[ORM\Entity(repositoryClass: UserProfileRepository::class)]
class UserProfile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: User::class, inversedBy: "profile")]
    #[ORM\JoinColumn(name:"user_id", referencedColumnName:"id", nullable: true)]
    private ?User $user = null;

    #[ORM\Column(type: "text", nullable: 'true')]
    private ?string $bio = null;
    
    #[ORM\Column(type: "text", length: 15, nullable: 'true')]
    private ?string $mobileNumber = null;

    #[ORM\Column(type: "text", nullable: 'true')]
    private ?string $country = null;

    #[ORM\Column(length: 180, type: "text", nullable: 'true')]
    private ?string $companyName = null;

    #[ORM\Column(length: 180, type: "text", nullable: 'true')]
    private ?string $companyWebsite = null;

    #[ORM\Column(length: 180, type: "text", nullable: 'true')]
    private ?string $facebook = null;

    #[ORM\Column(length: 180, type: "text", nullable: 'true')]
    private ?string $twitter = null;

    #[ORM\Column(length: 180, type: "text", nullable: 'true')]
    private ?string $instagram = null;

    #[ORM\Column(length: 180, type: "text", nullable: 'true')]
    private ?string $linkedin = null;

    #[ORM\Column(length: 180, type: "text", nullable: 'true')]
    private ?string $skype = null;

    #[ORM\Column(length: 180, type: "text", nullable: 'true')]
    private ?string $github = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): static
    {
        $this->bio = $bio;

        return $this;
    }

    public function getMobileNumber(): ?string
    {
        return $this->mobileNumber;
    }

    public function setMobileNumber(?string $mobileNumber): static
    {
        $this->mobileNumber = $mobileNumber;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): static
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getCompanyWebsite(): ?string
    {
        return $this->companyWebsite;
    }

    public function setCompanyWebsite(?string $companyWebsite): static
    {
        $this->companyWebsite = $companyWebsite;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): static
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): static
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): static
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(?string $linkedin): static
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    public function getSkype(): ?string
    {
        return $this->skype;
    }

    public function setSkype(?string $skype): static
    {
        $this->skype = $skype;

        return $this;
    }

    public function getGithub(): ?string
    {
        return $this->github;
    }

    public function setGithub(?string $github): static
    {
        $this->github = $github;

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
