<?php

namespace App\Entity;

use App\Repository\QuizStudentResultRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: QuizStudentResultRepository::class)]
#[UniqueEntity(fields: ['quiz', 'student'], message: 'Ce résultat est déjà créé pour ce quiz et cet élève.')]
class QuizStudentResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $quizTitle = null;

    #[ORM\Column(nullable: true)]
    private ?float $value = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column]
    private ?bool $isValidated = false;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $duration = null;

    #[ORM\ManyToOne(inversedBy: 'quizStudentResults')]
    private ?Quiz $quiz = null;

    #[ORM\ManyToOne(inversedBy: 'quizStudentResults')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $student = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Inscription $inscription = null;

    #[ORM\OneToMany(mappedBy: 'quizResult', targetEntity: QuizStudentEvent::class, orphanRemoval: true)]
    private Collection $quizStudentEvents;

    public function __construct()
    {
        $this->quizStudentEvents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuizTitle(): ?string
    {
        return $this->quizTitle;
    }

    public function setQuizTitle(string $quizTitle): static
    {
        $this->quizTitle = $quizTitle;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(?float $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function isIsValidated(): ?bool
    {
        return $this->isValidated;
    }

    public function setIsValidated(bool $isValidated): static
    {
        $this->isValidated = $isValidated;

        return $this;
    }

    public function getDuration(): ?\DateTimeInterface
    {
        return $this->duration;
    }

    public function setDuration(?\DateTimeInterface $duration): static
    {
        $this->duration = $duration;

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

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): static
    {
        $this->student = $student;

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
     * @return Collection<int, QuizStudentEvent>
     */
    public function getQuizStudentEvents(): Collection
    {
        return $this->quizStudentEvents;
    }

    public function addQuizStudentEvent(QuizStudentEvent $quizStudentEvent): static
    {
        if (!$this->quizStudentEvents->contains($quizStudentEvent)) {
            $this->quizStudentEvents->add($quizStudentEvent);
            $quizStudentEvent->setQuizResult($this);
        }

        return $this;
    }

    public function removeQuizStudentEvent(QuizStudentEvent $quizStudentEvent): static
    {
        if ($this->quizStudentEvents->removeElement($quizStudentEvent)) {
            // set the owning side to null (unless already changed)
            if ($quizStudentEvent->getQuizResult() === $this) {
                $quizStudentEvent->setQuizResult(null);
            }
        }

        return $this;
    }
}
