<?php

namespace App\Entity\HRMSystem;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\HRMSystem\CustomQuestionsRepository;

#[ORM\Entity(repositoryClass: CustomQuestionsRepository::class)]
class CustomQuestions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $question= null;

    #[ORM\Column(length: 255)]
    private ?string $isRequired = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "zoomMeetings")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $user = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getIsRequired(): ?string
    {
        return $this->isRequired;
    }

    public function setIsRequired(string $isRequired): static
    {
        $this->isRequired = $isRequired;

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
