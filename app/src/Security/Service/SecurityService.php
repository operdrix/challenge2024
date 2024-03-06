<?php

namespace App\Security\Service;

use App\Entity\Inscription;
use App\Entity\Training;
use App\Entity\TrainingSession;

class SecurityService
{
    public function canViewInscription(Inscription $inscription, Training $training): bool
    {
        return $inscription->getTraining() === $training;
    }

    public function canViewSession(Inscription $inscription, Training $training, TrainingSession $trainingSession): bool
    {
        return $trainingSession->getInscription() === $inscription && $inscription->getTraining() === $training;
    }
}