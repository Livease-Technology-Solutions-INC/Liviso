<?php

namespace App\Entity;

use App\Repository\WebhookRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WebhookRepository::class)]
class Webhook
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $module = null;

    #[ORM\Column(length: 255)]
    private ?string $URL= null;

    #[ORM\Column(length: 255)]
    private ?string $method = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModule(): ?string
    {
        return $this->module;
    }

    public function setModule(string $module): static
    {
        $this->module = $module;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->URL;
    }

    public function setUrl(string $URL): static
    {
        $this->URL= $URL;

        return $this;
    }
    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(string $method): static
    {
        $this->method = $method;

        return $this;
    }
}
