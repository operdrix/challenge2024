<?php

namespace App\Controller\App\Teacher;

use App\Entity\Inscription;
use App\Entity\Quiz;
use App\Entity\QuizQuestionAvailableAnswer;
use App\Entity\QuizQuestionStudentAnswer;
use App\Entity\QuizStudentResult;
use App\Entity\Student;
use App\Enum\QuizQuestionTypeEnum;
use App\Form\QuizStudentResultType;
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

        $totalQuizPoints = $em->getRepository(Quiz::class)->getTotalPoints($quiz);


        return $this->render('teacher/quiz/correction/index.html.twig', [
            'quiz' => $quiz,
            'students' => $students,
            'totalQuizPoints' => $totalQuizPoints
        ]);
    }

    #[Route('/{id}/correct/{studentId}', name: 'correct_student')]
    public function correctStudent(Quiz $quiz, $studentId, EntityManagerInterface $em, Request $request): Response
    {
        $quizAnswers = $em->getRepository(QuizQuestionStudentAnswer::class)->getAllStudentAnswersByQuizId($quiz->getId(), $studentId);

        $manualCorrectionAnswers = [];

        foreach ($quizAnswers as $quizAnswer) {
            if ($quizAnswer->getQuizQuestion()->getType()->value == QuizQuestionTypeEnum::TEXT->value)
            {
                $manualCorrectionAnswers[] = $quizAnswer;
            }
        }

        $form = $this->createForm(QuizQuestionStudentAnswerCollectionType::class, null, ['manualAnswers' => $manualCorrectionAnswers]);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($manualCorrectionAnswers as $manualCorrectionAnswer) {
                $points = $form->get($manualCorrectionAnswer->getId())->getData();
                $points = intval(max(0, min($manualCorrectionAnswer->getQuizQuestion()->getPoint(), $points)));
                $manualCorrectionAnswer->setResult($points);
                $em->persist($manualCorrectionAnswer);
            }
            $em->flush();

            $this->addFlash('success', 'Les réponses ont été corrigées avec succès pour cet étudiant.');
            return $this->redirectToRoute('teacher_quizzes_correct_student_feedback', ['id' => $quiz->getId(), 'studentId' => $studentId]);
        }

        $student = $em->getRepository(Student::class)->find($studentId);

        return $this->render('teacher/quiz/correction/student.html.twig', [
            'quiz' => $quiz,
            'student' => $student,
            'quizAnswers' => $quizAnswers,
            'form' => $form
        ]);
    }

    #[Route('/{id}/correct/{studentId}/feedback', name: 'correct_student_feedback')]
    public function addFeedback(Quiz $quiz, $studentId, EntityManagerInterface $em, Request $request): Response
    {
        $feedBack = $em->getRepository(QuizStudentResult::class)->findOneBy(['student' => $studentId, 'quiz' => $quiz->getId()]);
        if (empty($feedBack)) {
            $feedBack = new QuizStudentResult();
            $feedBack->setStudent($em->getRepository(Student::class)->find($studentId));
            $feedBack->setQuiz($quiz);
            $feedBack->setQuizTitle($quiz->getLabel());

            $inscription = $em->getRepository(Inscription::class)->findByStudentAndQuiz($studentId, $quiz->getId());


            $feedBack->setInscription($inscription);

            $totalStudentResult = 0;
            $quizAnswers = $em->getRepository(QuizQuestionStudentAnswer::class)->getAllStudentAnswersByQuizId($quiz->getId(), $studentId);
            foreach ($quizAnswers as $quizAnswer) {
                $totalStudentResult += $quizAnswer->getResult();
            }


            $feedBack->setValue($totalStudentResult);
        }
        $totalQuizPoints = $em->getRepository(Quiz::class)->getTotalPoints($quiz);

        $form = $this->createForm(QuizStudentResultType::class, $feedBack, ['max_points' => $totalQuizPoints]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $feedBack->setValue(min($totalQuizPoints, max(0, $feedBack->getValue())));
            $em->persist($feedBack);
            $em->flush();
            $this->addFlash('success', 'Le feedback a été ajouté avec succès.');
            return $this->redirectToRoute('teacher_quizzes_correct', ['id' => $quiz->getId()]);
        }

        return $this->render('teacher/quiz/correction/feedback.html.twig', [
            'quiz' => $quiz,
            'student' => $feedBack->getStudent(),
            'form' => $form
        ]);

    }
}
