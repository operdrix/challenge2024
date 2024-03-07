<?php

namespace App\Service\Interface;

use App\Entity\Training;
use App\Entity\TrainingBlock;

interface TrainingServiceInterface
{
    /**
     * Find next training block or null if it the last training block
     */
    public function findNextTrainingBlock(Training $training, int $position): ?TrainingBlock;
}
