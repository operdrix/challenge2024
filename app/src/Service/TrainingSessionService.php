<?php

namespace App\Service;

use App\Entity\TrainingSession as EntityTrainingSession;
use App\Service\Interface\TrainingSessionServiceInterface;

class TrainingSessionService implements TrainingSessionServiceInterface
{
    public function generateTitle(EntityTrainingSession $trainingSession): string
    {
        $title = $trainingSession->getInscription()->getTraining()->getTitle();

        if (!is_null($trainingSession->getInscription()->getGrade())) {
            $title .= ' - ' . $trainingSession->getInscription()->getGrade()->getLabel();
        }

        return $title;
    }
}
