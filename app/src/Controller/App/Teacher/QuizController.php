<?php

namespace App\Controller\App\Teacher;

use App\Entity\Quiz;
use App\Entity\QuizQuestionAvailableAnswer;
use App\Entity\QuizQuestionStudentAnswer;
use App\Entity\Student;
use App\Enum\QuizQuestionTypeEnum;
use App\Form\Type\QuizFilterType;
use App\Form\Type\QuizQuestionStudentAnswerCollectionType;
use App\Form\Type\QuizQuestionStudentAnswerType;
use App\Form\Type\QuizType;
use App\Service\FilteredListService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/teacher/quizzes', name: "teacher_quizzes_")]
class QuizController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(
        FilteredListService $filteredListService,
        Request                $request,
    ): Response
    {
        [$pagination, $form] = $filteredListService->prepareFilteredList(
            $request,
            QuizFilterType::class,
            Quiz::class
        );

        return $this->render('teacher/quiz/index.html.twig', [
            'pagination' => $pagination,
            "form" => $form
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request                     $request,
        EntityManagerInterface      $em,
        ?Quiz $quiz = null
    ): Response
    {
        $formOptions = [];
        if (empty($quiz)) {
            $quiz = new Quiz();
            $formOptions["validation_groups"] = [
                "Default",
            ];
        }
        $form = $this->createForm(QuizType::class, $quiz, $formOptions);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($quiz->getQuizQuestions() as $key => $question) {
                if (
                    $question->getType()->value == QuizQuestionTypeEnum::YESNO->value
                    && empty($question->getQuizQuestionAvailableAnswers())
                ) {
                    $availableAnswer1 = new QuizQuestionAvailableAnswer();
                    $availableAnswer1->setContent("Vrai");
                    $availableAnswer1->setIsCorrect($form->get('quizQuestions')[$key]->get('yesOrNo')->getData() === true);
                    $availableAnswer1->setQuizQuestion($question);
                    $em->persist($availableAnswer1);

                    $availableAnswer2 = new QuizQuestionAvailableAnswer();
                    $availableAnswer2->setContent("Faux");
                    $availableAnswer2->setIsCorrect($form->get('quizQuestions')[$key]->get('yesOrNo')->getData() === false);
                    $availableAnswer2->setQuizQuestion($question);
                    $em->persist($availableAnswer2);
                }
            }

            $em->persist($quiz);
            $em->flush();

            return $this->redirectToRoute('teacher_quizzes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('teacher/quiz/edit.html.twig', [
            'teacher' => $quiz,

            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Quiz $quiz, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $quiz->getId(), $request->request->get('_token'))) {
            $em->remove($quiz);
            $em->flush();
        }

        return $this->redirectToRoute('teacher_quiz_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/correct', name: 'correct', methods: ['GET'])]
    public function correct(Quiz $quiz, EntityManagerInterface $em): Response
    {
        $students = $em->getRepository(Student::class)->findStudentsByQuizAnswered($quiz->getId());

        return $this->render('teacher/quiz/correction/index.html.twig', [
            'quiz' => $quiz,
            'students' => $students
        ]);
    }

    #[Route('/{id}/correct/{studentId}', name: 'correct_student', methods: ['GET'])]
    public function correctStudent(Quiz $quiz, $studentId, EntityManagerInterface $em): Response
    {
        $quizAnswers = $em->getRepository(QuizQuestionStudentAnswer::class)->getAllStudentAnswersByQuizId($quiz->getId(), $studentId);

        $manualCorrectionAnswers = [];

        foreach ($quizAnswers as $quizAnswer) {
            if ($quizAnswer->getQuizQuestion()->getType()->value == QuizQuestionTypeEnum::TEXT->value)
            {
                $manualCorrectionAnswers[] = $quizAnswer;
            }
        }

        $form = $this->createForm(QuizQuestionStudentAnswerCollectionType::class, $manualCorrectionAnswers);

        dd($form);

        $student = $em->getRepository(Student::class)->find($studentId);

        return $this->render('teacher/quiz/correction/student.html.twig', [
            'quiz' => $quiz,
            'student' => $student,
            'quizAnswers' => $quizAnswers,
            'form' => $form
        ]);
    }
}
