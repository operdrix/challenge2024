<?php

namespace App\Controller\Api;

use App\Entity\Quiz;
use App\Entity\QuizStudentResult;
use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class QuizEventController extends AbstractController
{
    #[Route('/api/quiz/event', name: 'app_api_quiz_event')]
    public function index(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $post = $request->getPayload();
        $studentId = $post->get('student');
        $quizId = $post->get('quiz');
        $startedAt = $post->get('startedAt');
        $eventType = $post->get('eventType');

        $quiz = $em->getRepository(Quiz::class)->find($quizId);
        $student = $em->getRepository(Student::class)->find($studentId);

        $quizStudentResult = $em->getRepository(QuizStudentResult::class)->findBy(['quiz' => $quiz, 'student' => $student]);

        if (!$quizStudentResult) {
            return new JsonResponse(status: 500);
        }

        $quizStudentEvent = new QuizStudentEvent();
        $quizStudentEvent->setStartedAt($startedAt);
        $quizStudentEvent->setEventType($eventType);
        $quizStudentEvent->setQuizResult($quizStudentResult);

        $em->persist($quizStudentEvent);
        $em->flush();

        return new JsonResponse("L'événement a bien été enregistré", 200);

    }
}
