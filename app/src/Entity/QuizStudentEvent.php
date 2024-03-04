<?php

namespace App\Entity;

use App\Enum\EventTypeEnum;
use App\Repository\QuizStudentEventRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: QuizStudentEventRepository::class)]
#[UniqueEntity(fields: ['startedAt', 'student', 'eventType'], message: 'Cet événement existe déjà pour cet élève.')]
class QuizStudentEvent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $startedAt = null;

    #[ORM\Column(type: Types::STRING, length: 255, enumType: EventTypeEnum::class)]
    private ?EventTypeEnum $eventType = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $student = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeImmutable $startedAt): static
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getEventType(): ?EventTypeEnum
    {
        return $this->eventType;
    }

    public function setEventType(EventTypeEnum $eventType): static
    {
        $this->eventType = $eventType;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): static
    {
        $this->student = $student;

        return $this;
    }
}
