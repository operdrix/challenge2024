<?php

namespace App\Entity;

use App\Repository\QuizQuestionStudentAnswerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizQuestionStudentAnswerRepository::class)]
class QuizQuestionStudentAnswer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column]
    private ?float $result = null;

    #[ORM\ManyToOne(inversedBy: 'quizQuestionStudentAnswers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?QuizQuestion $quizQuestion = null;

    #[ORM\ManyToOne(inversedBy: 'quizQuestionStudentAnswers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $student = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getResult(): ?float
    {
        return $this->result;
    }

    public function setResult(float $result): static
    {
        $this->result = $result;

        return $this;
    }

    public function getQuizQuestion(): ?QuizQuestion
    {
        return $this->quizQuestion;
    }

    public function setQuizQuestion(?QuizQuestion $quizQuestion): static
    {
        $this->quizQuestion = $quizQuestion;

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
