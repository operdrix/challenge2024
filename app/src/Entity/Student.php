<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Élève
 */
#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student extends AbstractUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::JSON)]
    protected array $roles = ["ROLE_STUDENT"];

    #[ORM\OneToMany(targetEntity: QuizQuestionStudentAnswer::class, mappedBy: 'student')]
    private Collection $quizQuestionStudentAnswers;

    #[ORM\OneToMany(targetEntity: QuizStudentResult::class, mappedBy: 'student')]
    private Collection $quizStudentResults;

    #[ORM\ManyToMany(targetEntity: Inscription::class, mappedBy: 'students')]
    private Collection $inscriptions;

    #[ORM\OneToMany(targetEntity: TrainingSessionStudent::class, mappedBy: 'student')]
    private Collection $trainingSessionStudents;

    #[ORM\OneToMany(targetEntity: Progress::class, mappedBy: 'student')]
    private Collection $progress;

    public function __construct()
    {
        $this->quizQuestionStudentAnswers = new ArrayCollection();
        $this->quizStudentResults = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
        $this->trainingSessionStudents = new ArrayCollection();
        $this->progress = new ArrayCollection();
    }

    /********************************/
    /* AUTO GENERATED CONTENT BELOW */
    /********************************/

    public function getId(): ?int
    {
        return $this->id;
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
            $quizQuestionStudentAnswer->setStudent($this);
        }

        return $this;
    }

    public function removeQuizQuestionStudentAnswer(QuizQuestionStudentAnswer $quizQuestionStudentAnswer): static
    {
        if ($this->quizQuestionStudentAnswers->removeElement($quizQuestionStudentAnswer)) {
            // set the owning side to null (unless already changed)
            if ($quizQuestionStudentAnswer->getStudent() === $this) {
                $quizQuestionStudentAnswer->setStudent(null);
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
            $quizStudentResult->setStudent($this);
        }

        return $this;
    }

    public function removeQuizStudentResult(QuizStudentResult $quizStudentResult): static
    {
        if ($this->quizStudentResults->removeElement($quizStudentResult)) {
            // set the owning side to null (unless already changed)
            if ($quizStudentResult->getStudent() === $this) {
                $quizStudentResult->setStudent(null);
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
            $inscription->addStudent($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): static
    {
        if ($this->inscriptions->removeElement($inscription)) {
            $inscription->removeStudent($this);
        }

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
            $trainingSessionStudent->setStudent($this);
        }

        return $this;
    }

    public function removeTrainingSessionStudent(TrainingSessionStudent $trainingSessionStudent): static
    {
        if ($this->trainingSessionStudents->removeElement($trainingSessionStudent)) {
            // set the owning side to null (unless already changed)
            if ($trainingSessionStudent->getStudent() === $this) {
                $trainingSessionStudent->setStudent(null);
            }
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
            $progress->setStudent($this);
        }

        return $this;
    }

    public function removeProgress(Progress $progress): static
    {
        if ($this->progress->removeElement($progress)) {
            // set the owning side to null (unless already changed)
            if ($progress->getStudent() === $this) {
                $progress->setStudent(null);
            }
        }

        return $this;
    }
}
