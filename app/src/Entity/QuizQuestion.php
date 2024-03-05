<?php

namespace App\Entity;

use App\Enum\QuizQuestionTypeEnum;
use App\Repository\QuizQuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: QuizQuestionRepository::class)]
#[UniqueEntity(fields: ['title', 'quiz', 'type'], message: 'Cette question est déjà créée pour ce quiz.')]
class QuizQuestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::STRING, length: 255, enumType: QuizQuestionTypeEnum::class)]
    private ?QuizQuestionTypeEnum $type = null;

    #[ORM\Column]
    private ?float $point = null;

    #[ORM\ManyToOne(inversedBy: 'quizQuestions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quiz $quiz = null;

    #[ORM\OneToMany(targetEntity: QuizQuestionStudentAnswer::class, mappedBy: 'quizQuestion', orphanRemoval: true)]
    private Collection $quizQuestionStudentAnswers;

    #[ORM\OneToMany(mappedBy: 'quizQuestion', targetEntity: QuizQuestionAvailableAnswer::class, orphanRemoval: true)]
    private Collection $quizQuestionAvailableAnswers;

    public function __construct()
    {
        $this->quizQuestionStudentAnswers = new ArrayCollection();
        $this->quizQuestionAvailableAnswers = new ArrayCollection();
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

    public function getType(): ?QuizQuestionTypeEnum
    {
        return $this->type;
    }

    public function setType(QuizQuestionTypeEnum $type): static
    {
        $this->type = $type;

        return $this;
    }
    public function getPoint(): ?float
    {
        return $this->point;
    }

    public function setPoint(float $point): static
    {
        $this->point = $point;

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
     * @return Collection<int, QuizQuestionStudentAnswer>
     */
    public function getQuizQuestionStudentAnswers(): Collection
    {
        return $this->quizQuestionStudentAnswers;
    }

    public function addQuizQuestionStudentAnswer(QuizQuestionStudentAnswer $quizQuestionStudentAnswer): static
    {
        if (!$this->quizQuestionStudentAnswers->contains($quizQuestionStudentAnswer)) {
            $this->quizQuestionStudentAnswers->add($quizQuestionStudentAnswer);
            $quizQuestionStudentAnswer->setQuizQuestion($this);
        }

        return $this;
    }

    public function removeQuizQuestionStudentAnswer(QuizQuestionStudentAnswer $quizQuestionStudentAnswer): static
    {
        if ($this->quizQuestionStudentAnswers->removeElement($quizQuestionStudentAnswer)) {
            // set the owning side to null (unless already changed)
            if ($quizQuestionStudentAnswer->getQuizQuestion() === $this) {
                $quizQuestionStudentAnswer->setQuizQuestion(null);
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
            $quizQuestionAvailableAnswer->setQuizQuestion($this);
        }

        return $this;
    }

    public function removeQuizQuestionAvailableAnswer(QuizQuestionAvailableAnswer $quizQuestionAvailableAnswer): static
    {
        if ($this->quizQuestionAvailableAnswers->removeElement($quizQuestionAvailableAnswer)) {
            // set the owning side to null (unless already changed)
            if ($quizQuestionAvailableAnswer->getQuizQuestion() === $this) {
                $quizQuestionAvailableAnswer->setQuizQuestion(null);
            }
        }

        return $this;
    }
}
