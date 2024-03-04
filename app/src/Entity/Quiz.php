<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: QuizRepository::class)]
#[UniqueEntity(fields: ['label', 'training'], message: 'Ce quiz est déjà créé pour cette formation.')]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column]
    private ?bool $isOpened = false;

    #[ORM\Column(nullable: true)]
    private ?int $duration = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $limitDate = null;

    #[ORM\ManyToOne(inversedBy: 'quizzes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Training $training = null;

    #[ORM\OneToMany(targetEntity: QuizQuestion::class, mappedBy: 'quiz', orphanRemoval: true)]
    private Collection $quizQuestions;

    #[ORM\OneToMany(targetEntity: QuizQuestionAvailableAnswer::class, mappedBy: 'quiz', orphanRemoval: true)]
    private Collection $quizQuestionAvailableAnswers;

    #[ORM\OneToMany(targetEntity: QuizStudentResult::class, mappedBy: 'quiz')]
    private Collection $quizStudentResults;

    #[ORM\OneToMany(targetEntity: TrainingBlock::class, mappedBy: 'quiz')]
    private Collection $trainingBlocks;

    public function __construct()
    {
        $this->quizQuestions = new ArrayCollection();
        $this->quizQuestionAvailableAnswers = new ArrayCollection();
        $this->quizStudentResults = new ArrayCollection();
        $this->trainingBlocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function isIsOpened(): ?bool
    {
        return $this->isOpened;
    }

    public function setIsOpened(bool $isOpened): static
    {
        $this->isOpened = $isOpened;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getLimitDate(): ?\DateTimeImmutable
    {
        return $this->limitDate;
    }

    public function setLimitDate(?\DateTimeImmutable $limitDate): static
    {
        $this->limitDate = $limitDate;

        return $this;
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

    /**
     * @return Collection<int, QuizQuestion>
     */
    public function getQuizQuestions(): Collection
    {
        return $this->quizQuestions;
    }

    public function addQuizQuestion(QuizQuestion $quizQuestion): static
    {
        if (!$this->quizQuestions->contains($quizQuestion)) {
            $this->quizQuestions->add($quizQuestion);
            $quizQuestion->setQuiz($this);
        }

        return $this;
    }

    public function removeQuizQuestion(QuizQuestion $quizQuestion): static
    {
        if ($this->quizQuestions->removeElement($quizQuestion)) {
            // set the owning side to null (unless already changed)
            if ($quizQuestion->getQuiz() === $this) {
                $quizQuestion->setQuiz(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, QuizQuestionAvailableAnswer>
     */
    public function getQuizQuestionAvailableAnswers(): Collection
    {
        return $this->quizQuestionAvailableAnswers;
    }

    public function addQuizQuestionAvailableAnswer(QuizQuestionAvailableAnswer $quizQuestionAvailableAnswer): static
    {
        if (!$this->quizQuestionAvailableAnswers->contains($quizQuestionAvailableAnswer)) {
            $this->quizQuestionAvailableAnswers->add($quizQuestionAvailableAnswer);
            $quizQuestionAvailableAnswer->setQuiz($this);
        }

        return $this;
    }

    public function removeQuizQuestionAvailableAnswer(QuizQuestionAvailableAnswer $quizQuestionAvailableAnswer): static
    {
        if ($this->quizQuestionAvailableAnswers->removeElement($quizQuestionAvailableAnswer)) {
            // set the owning side to null (unless already changed)
            if ($quizQuestionAvailableAnswer->getQuiz() === $this) {
                $quizQuestionAvailableAnswer->setQuiz(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, QuizStudentResult>
     */
    public function getQuizStudentResults(): Collection
    {
        return $this->quizStudentResults;
    }

    public function addQuizStudentResult(QuizStudentResult $quizStudentResult): static
    {
        if (!$this->quizStudentResults->contains($quizStudentResult)) {
            $this->quizStudentResults->add($quizStudentResult);
            $quizStudentResult->setQuiz($this);
        }

        return $this;
    }

    public function removeQuizStudentResult(QuizStudentResult $quizStudentResult): static
    {
        if ($this->quizStudentResults->removeElement($quizStudentResult)) {
            // set the owning side to null (unless already changed)
            if ($quizStudentResult->getQuiz() === $this) {
                $quizStudentResult->setQuiz(null);
            }
        }

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
            $trainingBlock->setQuiz($this);
        }

        return $this;
    }

    public function removeTrainingBlock(TrainingBlock $trainingBlock): static
    {
        if ($this->trainingBlocks->removeElement($trainingBlock)) {
            // set the owning side to null (unless already changed)
            if ($trainingBlock->getQuiz() === $this) {
                $trainingBlock->setQuiz(null);
            }
        }

        return $this;
    }
}
