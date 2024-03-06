<?php

namespace App\Service;

use App\Entity\QuizQuestion;
use Doctrine\ORM\EntityManagerInterface;

class AnswerCorrector
{
    public function correctAnswer(array|string $answer, QuizQuestion $question): ?float
    {
        switch ($question->getType()) {
            case "YESNO":
            case "UNIQUE":
                return $this->correctUniqueAnswer($answer, $question);
            case "MULTIPLE":
                return $this->correctMultipleAnswer($answer, $question);
            default:
                return null;
        }
    }

    public function correctUniqueAnswer(string $answer, QuizQuestion $quizQuestion): float
    {
        $correctAnswer = false;
        foreach ($quizQuestion->getQuizQuestionAvailableAnswers() as $availableAnswer) {
            if ($availableAnswer->isIsCorrect()) {
                $correctAnswer = $availableAnswer->getContent();
                break;
            }
        }
        return $answer == $correctAnswer ? $quizQuestion->getPoint() : 0;
    }

    public function correctMultipleAnswer(array $answers, QuizQuestion $quizQuestion): float
    {
        $correctAnswers = [];
        foreach ($quizQuestion->getQuizQuestionAvailableAnswers() as $availableAnswer) {
            if ($availableAnswer->isIsCorrect()) {
                $correctAnswers[] = $availableAnswer->getContent();
            }
        }
        return $answers == $correctAnswers ? $quizQuestion->getPoint() : 0;
    }
}
