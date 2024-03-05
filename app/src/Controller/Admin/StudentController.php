<?php

namespace App\Controller\Admin;

use App\Entity\Student;
use App\Form\Type\StudentType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Écran élèves
 */
#[Route('/admin/students', name: "admin_students_")]
class StudentController extends AbstractController
{
    /**
     * Liste
     */
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(
        EntityManagerInterface $em,
        PaginatorInterface $paginator,
        Request $request
    ): Response
    {
        $query = $em->getRepository(Student::class)->getBaseQueryBuilder();

        $pagination = $paginator->paginate(
            $query,
            $request->query->get("page", 1),
            20
        );

        return $this->render('admin/student/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Formulaire
     */
    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request, 
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        ?Student $student = null
    ): Response
    {
        $formOptions = [];
        if (empty($student)) {
            $student = new Student();
            $formOptions["validation_groups"] = [
                "Default",
                "user_new"
            ];
        }
        
        $form = $this->createForm(StudentType::class, $student, $formOptions);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!empty($student->getPlainPassword())) {
                $student->setPassword($passwordHasher->hashPassword($student, $student->getPlainPassword()));
                $student->eraseCredentials();
            }

            $em->persist($student);
            $em->flush();

            return $this->redirectToRoute('admin_students_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/student/edit.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }

    /**
     * Supprimer
     */
    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Student $student, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$student->getId(), $request->request->get('_token'))) {
            $em->remove($student);
            $em->flush();
        }

        return $this->redirectToRoute('admin_students_index', [], Response::HTTP_SEE_OTHER);
    }
}
