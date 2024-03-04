<?php

namespace App\Entity;

use App\Repository\TrainingBlockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TrainingBlockRepository::class)]
#[UniqueEntity(fields: ['training', 'content'], message: 'Ce bloc de formation existe déjà pour cette formation.')]
class TrainingBlock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'trainingBlocks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Training $training = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\ManyToMany(targetEntity: TrainingSession::class, mappedBy: 'trainingBlocks')]
    private Collection $trainingSessions;

    #[ORM\ManyToMany(targetEntity: Progress::class, mappedBy: 'trainingBlocks')]
    private Collection $progress;

    #[ORM\ManyToOne(inversedBy: 'trainingBlocks')]
    private ?Quiz $quiz = null;

    #[ORM\ManyToMany(targetEntity: Resource::class)]
    private Collection $resources;

    public function __construct()
    {
        $this->trainingSessions = new ArrayCollection();
        $this->progress = new ArrayCollection();
        $this->resources = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTraining(): ?Training
    {
        return $this->training;
    }

    public function setTraining(?Training $training): static
    {
        $this->training = $training;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, TrainingSession>
     */
    public function getTrainingSessions(): Collection
    {
        return $this->trainingSessions;
    }

    public function addTrainingSession(TrainingSession $trainingSession): static
    {
        if (!$this->trainingSessions->contains($trainingSession)) {
            $this->trainingSessions->add($trainingSession);
            $trainingSession->addTrainingBlock($this);
        }

        return $this;
    }

    public function removeTrainingSession(TrainingSession $trainingSession): static
    {
        if ($this->trainingSessions->removeElement($trainingSession)) {
            $trainingSession->removeTrainingBlock($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Progress>
     */
    public function getProgress(): Collection
    {
        return $this->progress;
    }

    public function addProgress(Progress $progress): static
    {
        if (!$this->progress->contains($progress)) {
            $this->progress->add($progress);
            $progress->addTrainingBlock($this);
        }

        return $this;
    }

    public function removeProgress(Progress $progress): static
    {
        if ($this->progress->removeElement($progress)) {
            $progress->removeTrainingBlock($this);
        }

        return $this;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): static
    {
        $this->quiz = $quiz;

        return $this;
    }

    /**
     * @return Collection<int, Resource>
     */
    public function getResources(): Collection
    {
        return $this->resources;
    }

    public function addResource(Resource $resource): static
    {
        if (!$this->resources->contains($resource)) {
            $this->resources->add($resource);
        }

        return $this;
    }

    public function removeResource(Resource $resource): static
    {
        $this->resources->removeElement($resource);

        return $this;
    }
}
