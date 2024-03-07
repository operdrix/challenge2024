<?php

namespace App\Controller\Api;

use App\Entity\QuizQuestion;
use App\Entity\QuizQuestionStudentAnswer;
use App\Entity\Student;
use App\Service\AnswerCorrector;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class QuestionAnswerController extends AbstractController
{
    #[Route('/api/question/answer', name: 'app_api_question_answer')]
    public function index(): Response
    {
        return $this->render('api/question_answer/index.html.twig', [
            'controller_name' => 'QuestionAnswerController',
        ]);
    }

    #[Route('/api/question/answer/{id}', name: 'app_api_question_answer_id', methods: ['POST'])]
    public function saveAnswer(Request $request, $id, EntityManagerInterface $em, AnswerCorrector $answerCorrector): JsonResponse
    {
        $post = $request->getPayload();
        $studentId = $post->get('student');

        $student = $em->getRepository(Student::class)->find($studentId);
        $answer = $post->get('answer');

        $quizQuestion = $em->getRepository(QuizQuestion::class)->find($id);

        // Vérifier que l'étudiant est bien dans le cours qui propose ce quiz
        $studentsInTraining = $em->getRepository(Student::class)->getQuizByTrainingAndStudent($quizQuestion->getQuiz()->getTraining()->getId(), $studentId);

        $gradeStudentsInTraining = $em->getRepository(Student::class)->getQuizByTrainingAndGradeStudent($quizQuestion->getQuiz()->getTraining()->getId(), $studentId);

        if (empty($studentsInTraining) && empty($gradeStudentsInTraining)) {
            return new JsonResponse("Vous n'avez pas accès à ce quiz", 403);
        }

        $quizAnswer = new QuizQuestionStudentAnswer();
        $quizAnswer->setStudent($student);
        $quizAnswer->setContent($answer);
        $quizAnswer->setQuizQuestion($quizQuestion);

        $result = $answerCorrector->correctAnswer($answer, $quizQuestion);

        $quizAnswer->setResult($result);

        $em->persist($quizAnswer);
        $em->flush();

        return new JsonResponse("Votre réponse a bien été enregistrée", 200);

    }
}
