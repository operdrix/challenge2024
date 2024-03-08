<?php

namespace App\Service\Interface;

use App\Entity\Grade;
use App\Entity\Inscription;
use App\Entity\Progress;
use App\Entity\Student;
use App\Entity\Teacher;
use App\Entity\Training;
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

    /**
     * Renvoie un tableau formatté avec le taux de progression de chaque inscription et les notes associées
     */
    public function getProgressArrayForStudent(Student $student): array;

    /**
     * Renvoie un tableau formatté avec le taux de progression d'une inscription et les notes associées
     */
    public function getProgressArrayForStudentByInscription(Student $student, Inscription $inscription): array;

    /**
     * Renvoie un tableau formatté avec le taux de progression d'un étudiant à l'inscription individuelle
     * pour chacun des cours suivis crée par le formateur
     */
    public function getProgressArrayForTeacherByStudent(Teacher $teacher, Student $student): array;

    /**
     * Renvoie un tableau formatté avec le taux de progression d'une classe pour chaque étudiants
     * pour chacun des cours suivis crée par le formateur
     */
    public function getProgressArrayForteacherByGrade(Teacher $teacher, Grade $grade): array;

    /**
     * Renvoie un tableau formatté avec le taux de progression des étudiants inscris au cours
     */
    public function getProgressArrayForTeacherByTraining(Teacher $teacher, Training $training): array;
}
