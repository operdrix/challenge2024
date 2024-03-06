<?php

namespace App\Controller\App\Teacher;

use App\Repository\GradeRepository;
use App\Repository\StudentRepository;
use App\Repository\TrainingRepository;
use App\Repository\TrainingSessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/teacher', name: 'teacher_')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        TrainingRepository $trainingRepository,
        TrainingSessionRepository $trainingSessionRepository,
        StudentRepository $studentRepository,
        GradeRepository $gradeRepository
    ): Response
    {
        $teacherTrainings = $trainingRepository->findBy(['teacher' => $this->getUser()]);
        $nextTrainingsSessions = $trainingSessionRepository->findNextTrainingsSessions($this->getUser());
        $studentsInGrade = $studentRepository->findStudentsWithGradeByTeacher($this->getUser());
        $studentsOutGrade = $studentRepository->findStudentsWithoutGradeByTeacher($this->getUser());
        $grades = $gradeRepository->findGradesByTeacher($this->getUser());
        return $this->render('teacher/dashboard/index.html.twig', [
            'trainings' => $teacherTrainings,
            'nextTrainingsSessions' => $nextTrainingsSessions,
            'studentsInGrade' => $studentsInGrade,
            'studentsOutGrade' => $studentsOutGrade,
            'grades' => $grades
        ]);
    }
}
