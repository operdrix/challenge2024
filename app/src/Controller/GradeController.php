<?php

namespace App\Controller;

use App\Entity\Grade;
use App\Entity\School;
use App\Form\Type\GradeType;
use App\Repository\GradeRepository;
use App\Service\Interface\StudentServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/school/', name: 'app_grade_')]
#[IsGranted('ROLE_TEACHER')]
class GradeController extends AbstractController
{
    #[Route('{school_id}/grade', name: 'index', methods: ['GET'])]
    public function index(
        #[MapEntity(id: 'school_id')] School $school,
        GradeRepository $gradeRepository
    ): Response {
        return $this->render('grade/index.html.twig', [
            'grades' => $gradeRepository->findBy(['teacher' => $this->getUser(), 'school' => $school]),
            'school' => $school
        ]);
    }

    #[Route('{school_id}/grade/{id}/show', name: 'show', methods: ['GET'])]
    #[IsGranted('view', 'grade')]
    public function show(Grade $grade): Response
    {
        return $this->render('grade/show.html.twig', [
            'grade' => $grade,
        ]);
    }

    #[Route('{school_id}/grade/new', name: 'new', methods: ['GET', 'POST'])]
    #[Route('{school_id}/grade/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    #[IsGranted('edit', 'grade')]
    public function edit(
        #[MapEntity(id: 'school_id')] School $school,
        Request $request,
        ?Grade $grade,
        EntityManagerInterface $entityManager,
        StudentServiceInterface $studentService
    ): Response {
        if (is_null($grade)) {
            $grade = new Grade();
        }

        $grade->setTeacher($this->getUser());
        $grade->setSchool($school);

        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère une liste d'étudiants contrôllés 
            $grade->setStudents($studentService->bulkHandleNewStudent($grade->getStudents(), $grade));

            $entityManager->persist($grade);
            $entityManager->flush();

            return $this->redirectToRoute(
                'app_grade_index',
                ['school_id' => $grade->getSchool()->getId()],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->render('grade/edit.html.twig', [
            'grade' => $grade,
            'form' => $form,
        ]);
    }

    #[Route('{school_id}/grade/{id}', name: 'delete', methods: ['POST'])]
    #[IsGranted('delete', 'grade')]
    public function delete(#[MapEntity(id: 'school_id')] School $school, Request $request, Grade $grade, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $grade->getId(), $request->request->get('_token'))) {
            $entityManager->remove($grade);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_grade_index', [], Response::HTTP_SEE_OTHER);
    }
}
