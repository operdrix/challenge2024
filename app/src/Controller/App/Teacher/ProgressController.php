<?php

namespace App\Controller\App\Teacher;

use App\Entity\School;
use App\Entity\Student;
use App\Form\Type\StudentType;
use App\Form\Type\StudentFilterType;
use App\Form\Type\TeacherStudentType;
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
    public function index(StudentRepository $studentService): Response {

        return $this->render('teacher/progress/index.html.twig', [
            // 'pagination' => $pagination,
            // 'form' => $form
            'students' => $studentService->findAll()
        ]);
    }
}
