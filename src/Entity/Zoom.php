<?php

namespace App\Entity;

use App\Repository\ZoomRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ZoomRepository::class)]
class Zoom
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $project = null;

    #[ORM\Column(length: 255)]
    private ?string $user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $meetingTime = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\Column(length: 255)]
    private ?string $meetingURL = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getProject(): ?string
    {
        return $this->project;
    }

    public function setProject(string $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): static
    {
        $this->user = $user;

        return $this;
    }
    // public function setMeetingTime(string $date, string $time): void
    // {
    //     // Concatenate date and time strings
    //     $dateTimeStr = $date . ' ' . $time;

    //     // Create a DateTime object from the formatted string
    //     $meetingTime = \DateTime::createFromFormat('Y-m-d H:i:s', $dateTimeStr);

    //     // Set the meeting time
    //     $this->meetingTime = $meetingTime;
    // }

    public function getMeetingTime(): ?\DateTimeInterface
    {
        return $this->meetingTime;
    }

    public function setMeetingTime(\DateTimeInterface $meetingTime): static
    {
        $this->meetingTime = $meetingTime;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }
    public function getMeetingURL(): ?string
    {
        return $this->meetingURL;
    }

    public function setMeetingURL(string $meetingURL): static
    {
        $this->meetingURL = $meetingURL;

        return $this;
    }
    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }
}
