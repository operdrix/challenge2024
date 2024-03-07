<?php

namespace App\Service;

use App\Entity\Inscription;
use App\Entity\Progress;
use App\Entity\TrainingBlock;
use App\Entity\Student;
use App\Service\Interface\ProgressServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class ProgressService implements ProgressServiceInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function findOrCreateProgressByStudentAndInscription(Inscription $inscription, Student $student): Progress
    {
        $progress = $this->entityManager->getRepository(Progress::class)->findOneBy([
            'inscription' => $inscription,
            'student' => $student
        ]);

        if (is_null($progress)) {
            $progress = new Progress();
            $progress->setInscription($inscription);
            $progress->setStudent($student);

            $this->entityManager->persist($progress);
            $this->entityManager->flush();
        }

        return $progress;
    }

    public function validateTrainingBlock(
        Inscription $inscription,
        TrainingBlock $trainingBlock,
        Student $student
    ) {
        $progress = $this->findOrCreateProgressByStudentAndInscription(
            $inscription,
            $student
        );

        $progress->addTrainingBlock($trainingBlock);

        $this->entityManager->flush();
    }

    public function isTrainingBlockValidated(Inscription $inscription, Student $student, TrainingBlock $trainingBlock): bool
    {
        /** @var Progress $progress */
        $progress = $this->entityManager->getRepository(Progress::class)->findOneBy([
            'inscription' => $inscription,
            'student' => $student
        ]);

        return !is_null($progress) && $progress->getTrainingBlocks()->contains($trainingBlock);
    }
}
