<?php

namespace App\Controller\App\Teacher;

use App\Entity\School;
use App\Entity\Student;
use App\Entity\Grade;
use App\Form\Type\StudentType;
use App\Form\Type\StudentFilterType;
use App\Form\Type\TeacherStudentType;
use App\Form\Type\GradeFilterType;
use App\Repository\StudentRepository;
use App\Service\FilteredListService;
use App\Service\Interface\StudentServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/teacher/progress', name: "teacher_progress_")]
class ProgressController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(
        StudentRepository $studentService,
        FilteredListService $filteredListService,
        Request $request
        ): Response {

        $filtersStudent = [
            "teacher" => $this->getUser(),
        ];

        [$pagination, $form] = $filteredListService->prepareFilteredList(
            $request,
            StudentFilterType::class,
            Student::class,
            $filtersStudent
        );

        [$paginationGrade, $formGrade] = $filteredListService->prepareFilteredList(
            $request,
            GradeFilterType::class,
            Grade::class
        );;

        return $this->render('teacher/progress/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form,
            'paginationGrade' => $paginationGrade,
            'formGrade' => $formGrade,
            'students' => $studentService->findAll()
        ]);
    }
}
