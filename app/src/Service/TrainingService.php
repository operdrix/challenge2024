<?php

namespace App\Service;

use App\Entity\Training;
use App\Entity\TrainingBlock;
use App\Service\Interface\TrainingServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class TrainingService implements TrainingServiceInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function findNextTrainingBlock(Training $training, int $position): ?TrainingBlock
    {
        return $this->entityManager->getRepository(TrainingBlock::class)
            ->findOneBy([
                'training' => $training,
                'position' => ++$position
            ]);
    }
}
