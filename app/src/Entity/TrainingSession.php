<?php

namespace App\Entity;

use App\Repository\TrainingSessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TrainingSessionRepository::class)]
#[UniqueEntity(fields: ['startDate', 'length'], message: 'Une session de formation existe déjà à cette date et pour cette durée.')]
class TrainingSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $length = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column]
    private ?bool $isOnline = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sessionLink = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $place = null;

    #[ORM\ManyToMany(targetEntity: TrainingBlock::class, inversedBy: 'trainingSessions')]
    private Collection $trainingBlocks;

    #[ORM\ManyToOne(inversedBy: 'trainingSessions')]
    private ?Inscription $inscription = null;

    #[ORM\OneToMany(targetEntity: TrainingSessionStudent::class, mappedBy: 'trainingSession')]
    private Collection $trainingSessionStudents;

    public function __construct()
    {
        $this->trainingBlocks = new ArrayCollection();
        $this->trainingSessionStudents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(int $length): static
    {
        $this->length = $length;

        return $this;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeImmutable $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function isIsOnline(): ?bool
    {
        return $this->isOnline;
    }

    public function setIsOnline(bool $isOnline): static
    {
        $this->isOnline = $isOnline;

        return $this;
    }

    public function getSessionLink(): ?string
    {
        return $this->sessionLink;
    }

    public function setSessionLink(?string $sessionLink): static
    {
        $this->sessionLink = $sessionLink;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(?string $place): static
    {
        $this->place = $place;

        return $this;
    }

    /**
     * @return Collection<int, TrainingBlock>
     */
    public function getTrainingBlocks(): Collection
    {
        return $this->trainingBlocks;
    }

    public function addTrainingBlock(TrainingBlock $trainingBlock): static
    {
        if (!$this->trainingBlocks->contains($trainingBlock)) {
            $this->trainingBlocks->add($trainingBlock);
        }

        return $this;
    }

    public function removeTrainingBlock(TrainingBlock $trainingBlock): static
    {
        $this->trainingBlocks->removeElement($trainingBlock);

        return $this;
    }

    public function getInscription(): ?Inscription
    {
        return $this->inscription;
    }

    public function setInscription(?Inscription $inscription): static
    {
        $this->inscription = $inscription;

        return $this;
    }

    /**
     * @return Collection<int, TrainingSessionStudent>
     */
    public function getTrainingSessionStudents(): Collection
    {
        return $this->trainingSessionStudents;
    }

    public function addTrainingSessionStudent(TrainingSessionStudent $trainingSessionStudent): static
    {
        if (!$this->trainingSessionStudents->contains($trainingSessionStudent)) {
            $this->trainingSessionStudents->add($trainingSessionStudent);
            $trainingSessionStudent->setTrainingSession($this);
        }

        return $this;
    }

    public function removeTrainingSessionStudent(TrainingSessionStudent $trainingSessionStudent): static
    {
        if ($this->trainingSessionStudents->removeElement($trainingSessionStudent)) {
            // set the owning side to null (unless already changed)
            if ($trainingSessionStudent->getTrainingSession() === $this) {
                $trainingSessionStudent->setTrainingSession(null);
            }
        }

        return $this;
    }
}
