<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class EditUserDto
{
    /**
     * @Assert\NotBlank()
     */
    private $name;


    private $userId;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }
}
