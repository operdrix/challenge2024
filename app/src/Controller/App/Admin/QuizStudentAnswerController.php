<?php

namespace App\Controller\Admin;

use App\Entity\Quiz;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quiz/student', name: 'app_quiz_student_answer_')]
class QuizStudentAnswerController extends AbstractController
{
    #[Route('/all/{id}', name: 'all')]
    public function all(?Quiz $id, EntityManagerInterface $em): Response
    {

        $quiz = $em->getRepository(Quiz::class)->find($id);

        return $this->render('quiz_student_answer/index.html.twig', [
            'quiz' => $quiz,
        ]);
    }
}
