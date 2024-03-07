<?php

namespace App\Controller\App\Student;

use App\Entity\Student;
use App\Form\Type\StudentType;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/student/parameters', name: 'student_parameters_')]
class StudentParametersController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Vérification que l'utilisateur est connecté
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        // Vérification que l'utilisateur est bien un étudiant ROLE_STUDENT
        if (!$this->isGranted('ROLE_STUDENT')) {
            return $this->redirectToRoute('app_login');
        }

        // Récupération de l'étudiant connecté
        $student = $this->getUser();


        $form = $this->createForm(StudentType::class, $student, [
            'action' => 'isStudentParameterPage',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('student_parameters_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student/student_parameters/edit.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }

}
