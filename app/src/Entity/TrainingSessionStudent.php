<?php

namespace App\Entity;

use App\Repository\TrainingSessionStudentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TrainingSessionStudentRepository::class)]
#[UniqueEntity(fields: ['trainingSession', 'student'], message: 'Cet étudiant est déjà inscrit à cette session.')]
class TrainingSessionStudent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isPresent = false;

    #[ORM\ManyToOne(inversedBy: 'trainingSessionStudents')]
    private ?TrainingSession $trainingSession = null;

    #[ORM\ManyToOne(inversedBy: 'trainingSessionStudents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $student = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsPresent(): ?bool
    {
        return $this->isPresent;
    }

    public function setIsPresent(bool $isPresent): static
    {
        $this->isPresent = $isPresent;

        return $this;
    }

    public function getTrainingSession(): ?TrainingSession
    {
        return $this->trainingSession;
    }

    public function setTrainingSession(?TrainingSession $trainingSession): static
    {
        $this->trainingSession = $trainingSession;

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
