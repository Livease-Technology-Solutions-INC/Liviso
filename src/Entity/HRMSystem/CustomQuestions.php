<?php

namespace App\Entity\HRMSystem;

use App\Repository\HRMSystem\CustomQuestionsRepository;
use Doctrine\ORM\Mapping as ORM;

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
}
