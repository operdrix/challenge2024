<?php

namespace App\Entity;

use App\Enum\DifficultyEnum;
use App\Repository\TrainingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TrainingRepository::class)]
#[UniqueEntity(fields: ['title', 'teacher'], message: 'Cette formation existe déjà.')]
class Training
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $length = null;

    #[ORM\Column(type: Types::STRING, length: 255, enumType: DifficultyEnum::class)]
    private ?DifficultyEnum $difficulty = null;

    #[ORM\ManyToOne(inversedBy: 'trainings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Teacher $teacher = null;

    #[ORM\OneToMany(targetEntity: TrainingBlock::class, mappedBy: 'training')]
    private Collection $trainingBlocks;

    #[ORM\OneToMany(targetEntity: TrainingObjective::class, mappedBy: 'training')]
    private Collection $trainingObjectives;

    #[ORM\OneToMany(targetEntity: Quiz::class, mappedBy: 'training')]
    private Collection $quizzes;

    #[ORM\OneToMany(targetEntity: Resource::class, mappedBy: 'training', orphanRemoval: true)]
    private Collection $resources;

    #[ORM\OneToMany(targetEntity: Inscription::class, mappedBy: 'training')]
    private Collection $inscriptions;

    #[ORM\ManyToMany(targetEntity: TrainingCategory::class)]
    private Collection $categories;

    public function __construct()
    {
        $this->trainingBlocks = new ArrayCollection();
        $this->trainingObjectives = new ArrayCollection();
        $this->quizzes = new ArrayCollection();
        $this->resources = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
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

    public function getDifficulty(): ?DifficultyEnum
    {
        return $this->difficulty;
    }

    public function setDifficulty(DifficultyEnum $difficulty): static
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): static
    {
        $this->teacher = $teacher;

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
            $trainingBlock->setTraining($this);
        }

        return $this;
    }

    public function removeTrainingBlock(TrainingBlock $trainingBlock): static
    {
        if ($this->trainingBlocks->removeElement($trainingBlock)) {
            // set the owning side to null (unless already changed)
            if ($trainingBlock->getTraining() === $this) {
                $trainingBlock->setTraining(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TrainingObjective>
     */
    public function getTrainingObjectives(): Collection
    {
        return $this->trainingObjectives;
    }

    public function addTrainingObjective(TrainingObjective $trainingObjective): static
    {
        if (!$this->trainingObjectives->contains($trainingObjective)) {
            $this->trainingObjectives->add($trainingObjective);
            $trainingObjective->setTraining($this);
        }

        return $this;
    }

    public function removeTrainingObjective(TrainingObjective $trainingObjective): static
    {
        if ($this->trainingObjectives->removeElement($trainingObjective)) {
            // set the owning side to null (unless already changed)
            if ($trainingObjective->getTraining() === $this) {
                $trainingObjective->setTraining(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Quiz>
     */
    public function getQuizzes(): Collection
    {
        return $this->quizzes;
    }

    public function addQuiz(Quiz $quiz): static
    {
        if (!$this->quizzes->contains($quiz)) {
            $this->quizzes->add($quiz);
            $quiz->setTraining($this);
        }

        return $this;
    }

    public function removeQuiz(Quiz $quiz): static
    {
        if ($this->quizzes->removeElement($quiz)) {
            // set the owning side to null (unless already changed)
            if ($quiz->getTraining() === $this) {
                $quiz->setTraining(null);
            }
        }

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
            $resource->setTraining($this);
        }

        return $this;
    }

    public function removeResource(Resource $resource): static
    {
        if ($this->resources->removeElement($resource)) {
            // set the owning side to null (unless already changed)
            if ($resource->getTraining() === $this) {
                $resource->setTraining(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): static
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions->add($inscription);
            $inscription->setTraining($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): static
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getTraining() === $this) {
                $inscription->setTraining(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TrainingCategory>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(TrainingCategory $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(TrainingCategory $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
