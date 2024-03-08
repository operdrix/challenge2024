<?php

namespace App\Entity;

use App\Repository\ProgressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ProgressRepository::class)]
#[UniqueEntity(fields: ['inscription', 'student'], message: 'Cet élève est déjà inscrit à cette formation.')]
class Progress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: TrainingBlock::class, inversedBy: 'progress')]
    private Collection $trainingBlocks;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Inscription $inscription = null;

    #[ORM\ManyToOne(inversedBy: 'progress')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $student = null;

    public function __construct()
    {
        $this->trainingBlocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
