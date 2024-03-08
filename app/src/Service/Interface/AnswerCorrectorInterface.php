<?php

namespace App\Service\Interface;

use App\Entity\QuizQuestion;

interface AnswerCorrectorInterface
{
    /**
     * Manage answer corrector function management
     */
    public function correctAnswer(array|string $answer, QuizQuestion $question): ?float;
}
