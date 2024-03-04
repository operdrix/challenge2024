<?php

namespace App\Entity;

use App\Repository\QuizQuestionAvailableAnswerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: QuizQuestionAvailableAnswerRepository::class)]
#[UniqueEntity(fields: ['content', 'quiz'], message: 'Cette réponse est déjà associée à cette question.')]
class QuizQuestionAvailableAnswer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column]
    private ?bool $isCorrect = false;

    #[ORM\ManyToOne(inversedBy: 'quizQuestionAvailableAnswers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quiz $quiz = null;

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

    public function isIsCorrect(): ?bool
    {
        return $this->isCorrect;
    }

    public function setIsCorrect(bool $isCorrect): static
    {
        $this->isCorrect = $isCorrect;

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
}
