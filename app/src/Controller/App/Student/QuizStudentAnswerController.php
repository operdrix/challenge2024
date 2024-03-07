<?php

namespace App\Controller\App\Student;

use App\Entity\Quiz;
use App\Entity\Student;
use App\Form\AnswerQuizStudentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/student/quiz', name: 'student_student_answer_')]
class QuizStudentAnswerController extends AbstractController
{
    #[Route('/all/{id}', name: 'all')]
    public function all(?Quiz $id, EntityManagerInterface $em, Request $request): Response
    {
        $quiz = $em->getRepository(Quiz::class)->find($id);

        $isStudentInQuizTraining = $em->getRepository(Student::class)->isStudentInTrainingByQuiz($this->getUser()->getId(), $id);

        $isGradeStudentInQuizTraining = $em->getRepository(Student::class)->isGradeStudentInTrainingByQuiz($this->getUser()->getId(), $id);


        if (!$isStudentInQuizTraining && !$isGradeStudentInQuizTraining) {
            throw $this->createNotFoundException();
        }

        return $this->render('student/quiz_student_answer/index.html.twig', [
            'quiz' => $quiz,
        ]);
    }
}
