<?php

namespace App\Service\Interface;

use App\Entity\TrainingSession;

interface TrainingSessionServiceInterface
{
    /**
     * Generate a title based on training and grade or student
     */
    public function generateTitle(TrainingSession $trainingSession): string;
}
