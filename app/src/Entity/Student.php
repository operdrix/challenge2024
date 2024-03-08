<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Élève
 */
#[ORM\Entity(repositoryClass: StudentRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Un compte existe déjà avec cet email.')]
class Student extends AbstractUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Roles
     */
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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photoFilename = null;

    #[ORM\ManyToMany(targetEntity: Grade::class, inversedBy: 'students')]
    private Collection $grades;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: Conversation::class)]
    private Collection $conversations;

    public function __construct()
    {
        $this->quizQuestionStudentAnswers = new ArrayCollection();
        $this->quizStudentResults = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
        $this->trainingSessionStudents = new ArrayCollection();
        $this->progress = new ArrayCollection();
        $this->grades = new ArrayCollection();
        $this->conversations = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPhotoFilename(): ?string
    {
        return $this->photoFilename;
    }

    public function setPhotoFilename(?string $photoFilename): static
    {
        $this->photoFilename = $photoFilename;

        return $this;
    }

    /**
     * @return Collection<int, Grade>
     */
    public function getGrades(): Collection
    {
        return $this->grades;
    }

    public function addGrade(Grade $grade): static
    {
        if (!$this->grades->contains($grade)) {
            $this->grades->add($grade);
        }

        return $this;
    }

    public function removeGrade(Grade $grade): static
    {
        $this->grades->removeElement($grade);

        return $this;
    }

    /**
     * @return Collection<int, Conversation>
     */
    public function getConversations(): Collection
    {
        return $this->conversations;
    }

    public function addConversation(Conversation $conversation): static
    {
        if (!$this->conversations->contains($conversation)) {
            $this->conversations->add($conversation);
            $conversation->setStudent($this);
        }

        return $this;
    }

    public function removeConversation(Conversation $conversation): static
    {
        if ($this->conversations->removeElement($conversation)) {
            // set the owning side to null (unless already changed)
            if ($conversation->getStudent() === $this) {
                $conversation->setStudent(null);
            }
        }

        return $this;
    }
}
