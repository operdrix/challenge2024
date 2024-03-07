<?php

namespace App\Controller\App\Teacher;

use App\Entity\School;
use App\Entity\Student;
use App\Form\Type\StudentType;
use App\Form\Type\StudentFilterType;
use App\Form\Type\TeacherStudentType;
use App\Repository\StudentRepository;
use App\Service\FilteredListService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/teacher/students', name: "teacher_students_")]
class StudentController extends AbstractController
{

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request                              $request,
        EntityManagerInterface               $em,
        ?Student                             $student = null
    ): Response
    {
        if (empty($student)) {
            $student = new Student();
        }

        $form = $this->createForm(TeacherStudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($student);
            $em->flush();

            return $this->redirectToRoute('teacher_schools_show', [
                "id" => $school->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('teacher/student/edit.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }
}
