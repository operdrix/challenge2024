<?php

namespace App\Service\Interface;

use App\Entity\Inscription;
use App\Entity\Progress;
use App\Entity\Student;
use App\Entity\TrainingBlock;

interface ProgressServiceInterface
{
    /**
     * Find Progress entity for given student and inscription
     * Create Progress entity if not created yet 
     */
    public function findOrCreateProgressByStudentAndInscription(Inscription $inscription, Student $student): Progress;

    /**
     * Validate a training block for given student 
     */
    public function validateTrainingBlock(Inscription $inscription, TrainingBlock $trainingBlock, Student $student);

    /**
     * Check if a training block is validated for current inscription and student
     */
    public function isTrainingBlockValidated(Inscription $inscription, Student $student, TrainingBlock $trainingBlock): bool;
}
