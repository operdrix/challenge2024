<?php

namespace App\Service;

use App\Entity\Grade;
use App\Entity\Inscription;
use App\Entity\Progress;
use App\Entity\Quiz;
use App\Entity\QuizStudentResult;
use App\Entity\TrainingBlock;
use App\Entity\Student;
use App\Entity\Teacher;
use App\Entity\Training;
use App\Repository\ProgressRepository;
use App\Service\Interface\ProgressServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class ProgressService implements ProgressServiceInterface
{
    private ProgressRepository $progressRepository;

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        $this->progressRepository = $this->entityManager->getRepository(Progress::class);
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

    public function getProgressArrayForStudent(Student $student): array
    {
        $progressArray = [];
        foreach ($student->getProgress() as $progress) {

            $progressArray = array_merge($progressArray, $this->generateProgressArray($progress));
        }

        return $progressArray;
    }

    public function getProgressArrayForStudentByInscription(Student $student, Inscription $inscription): array
    {
        $progressArray = [];
        $progresses = $this->progressRepository->findBy([
            'student' => $student,
            'inscription' => $inscription
        ]);

        foreach ($progresses as $progress) {
            $progressArray = array_merge($progressArray, $this->generateProgressArray($progress));
        }

        return $progressArray;
    }

    public function getProgressArrayForTeacherByStudent(Teacher $teacher, Student $student): array
    {
        $progressArray = [];
        $progresses = $this->progressRepository->findProgressForTeacherByStudent(
            $teacher,
            $student
        );

        foreach ($progresses as $progress) {
            $progressArray = array_merge($progressArray, $this->generateProgressArray($progress));
        }

        return $progressArray;
    }

    public function getProgressArrayForteacherByGrade(Teacher $teacher, Grade $grade): array
    {
        $progressArray = [];
        $progresses = $this->progressRepository->findProgressForTeacherByGrade(
            $teacher,
            $grade
        );

        foreach ($progresses as $progress) {
            $progressArray = array_merge($progressArray, $this->generateProgressArray($progress));
        }

        return $progressArray;
    }

    public function getProgressArrayForTeacherByTraining(Teacher $teacher, Training $training): array
    {
        $progressArray = [];
        $progresses = $this->progressRepository->findProgressForTeacherByTraining(
            $teacher,
            $training
        );

        foreach ($progresses as $progress) {
            $progressArray = array_merge($progressArray, $this->generateProgressArray($progress));
        }

        return $progressArray;
    }

    private function generateProgressArray(Progress $progress): array
    {
        $training = $progress->getInscription()->getTraining();
        $grade = $progress->getInscription()->getGrade();
        $student = $progress->getStudent();

        $progressArray[$progress->getId()] = [
            'studentId' => $student->getId(),
            'studentName' => $student->getLastname() . ' ' . $student->getFirstname(),
            'inscriptionId' => $progress->getInscription()->getId(),
            'trainingId' => $training->getId(),
            'trainingTitle' => $training->getTitle(),
            'trainingDifficulty' => $training->getDifficulty(),
            'gradeId' =>  is_null($grade) ? null : $grade->getId(),
            'gradeLabel' => is_null($grade) ? null : $grade->getLabel(),
            'numberOfValidatedBlocks' => sizeof($progress->getTrainingBlocks()),
            'numberOfTotalBlocks' => sizeof($training->getTrainingBlocks())
        ];

        // Fetch student result from progress->inscription
        $results = $this->entityManager->getRepository(QuizStudentResult::class)->findBy([
            'student' => $student,
            'inscription' => $progress->getInscription()
        ]);

        /** @var QuizStudentResult $result */
        foreach ($results as $result) {
            $progressArray[$progress->getId()]['results'][$result->getId()] = [
                'quizId' => $result->getQuiz()->getId(),
                'quizTitle' => $result->getQuizTitle(),
                'quizResult' => $result->getValue(),
                'quizTotal' => $this->entityManager->getRepository(Quiz::class)->getTotalPoints($result->getQuiz()),
                'feedback' => $result->getComment()
            ];
        }

        return $progressArray;
    }
}
